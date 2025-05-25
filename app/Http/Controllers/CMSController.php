<?php

namespace App\Http\Controllers;

use App\Models\CMSPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CMSController extends Controller
{
    // List all CMS pages
    public function index()
    {
        $pages = CMSPage::all();
        return response()->json($pages);
    }

    // Create a new CMS page
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'banner_image' => 'nullable|image|max:2048',
            'banner_link' => 'nullable|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $bannerImagePath = null;
        if ($request->hasFile('banner_image')) {
            $bannerImagePath = $request->file('banner_image')->store('cms_banners', 'public');
        }

        $slug = Str::slug($request->title);

        $page = CMSPage::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'banner_image' => $bannerImagePath,
            'banner_link' => $request->banner_link,
            'is_archived' => false,
        ]);

        return response()->json($page, 201);
    }

    // Show a CMS page
    public function show($id)
    {
        $page = CMSPage::findOrFail($id);
        return response()->json($page);
    }

    // Update a CMS page
    public function update(Request $request, $id)
    {
        $page = CMSPage::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'content' => 'nullable|string',
            'banner_image' => 'nullable|image|max:2048',
            'banner_link' => 'nullable|url',
            'is_archived' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->hasFile('banner_image')) {
            if ($page->banner_image) {
                Storage::disk('public')->delete($page->banner_image);
            }
            $page->banner_image = $request->file('banner_image')->store('cms_banners', 'public');
        }

        if ($request->has('title')) {
            $page->title = $request->title;
            $page->slug = Str::slug($request->title);
        }
        if ($request->has('content')) {
            $page->content = $request->content;
        }
        if ($request->has('banner_link')) {
            $page->banner_link = $request->banner_link;
        }
        if ($request->has('is_archived')) {
            $page->is_archived = $request->is_archived;
        }

        $page->save();

        return response()->json($page);
    }

    // Archive/unarchive a CMS page
    public function archive(Request $request, $id)
    {
        $page = CMSPage::findOrFail($id);
        $page->is_archived = !$page->is_archived;
        $page->save();

        return response()->json(['message' => 'Page archive status updated', 'is_archived' => $page->is_archived]);
    }
}
