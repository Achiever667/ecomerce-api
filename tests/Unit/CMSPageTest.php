<?php

namespace Tests\Unit;

use App\Models\CMSPage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CMSPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        $page = new CMSPage();

        $this->assertEquals(['title', 'slug', 'content', 'banner_image', 'banner_link', 'is_archived'], $page->getFillable());
    }
}
