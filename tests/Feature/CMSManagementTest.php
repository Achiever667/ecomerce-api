<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\CMSPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CMSManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_cms_page()
    {
        $admin = User::factory()->createOne();

        $this->actingAs($admin, 'sanctum');

        $response = $this->postJson('/api/cms-pages', [
            'title' => 'About Us',
            'content' => 'This is about us page content.',
            'banner_image' => 'http://example.com/banner.jpg',
            'banner_link' => 'http://example.com',
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function admin_can_update_cms_page()
    {
        $admin = User::factory()->createOne();
        $page = CMSPage::factory()->create();

        $this->actingAs($admin, 'sanctum');

        $response = $this->putJson("/api/cms-pages/{$page->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content.',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_archive_and_unarchive_cms_page()
    {
        $admin = User::factory()->createOne();
        $page = CMSPage::factory()->create(['archived' => false]);

        $this->actingAs($admin, 'sanctum');

        $archiveResponse = $this->putJson("/api/cms-pages/{$page->id}/archive");

        $archiveResponse->assertStatus(200);

        $unarchiveResponse = $this->putJson("/api/cms-pages/{$page->id}/archive");

        $unarchiveResponse->assertStatus(200);
    }
}
