<?php

namespace Database\Factories;

use App\Models\CMSPage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CMSPageFactory extends Factory
{
    protected $model = CMSPage::class;

    public function definition()
    {
        $title = $this->faker->sentence(3);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraph(),
            'banner_image' => null,
            'banner_link' => null,
            'is_archived' => false,
        ];
    }
}
