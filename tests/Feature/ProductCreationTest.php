<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_product()
    {
        $admin = User::factory()->create();

        $this->actingAs($admin, 'sanctum');

        $response = $this->postJson('/api/products', [
            'name' => 'Test Product',
            'price' => 99.99,
            'description' => 'Test description',
            'category' => 'Test Category',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'name' => 'Test Product',
                'price' => 99.99,
                'description' => 'Test description',
                'category' => 'Test Category',
            ]);
    }
}
