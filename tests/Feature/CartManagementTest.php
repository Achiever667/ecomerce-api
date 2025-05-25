<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_add_product_to_cart()
    {
        $user = User::factory()->createOne();
        $product = Product::factory()->createOne();

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/cart', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function user_can_view_cart()
    {
        $user = User::factory()->createOne();

        $this->actingAs($user, 'sanctum');

        $response = $this->getJson('/api/cart');

        $response->assertStatus(200);
    }

    /** @test */
    public function user_can_remove_item_from_cart()
    {
        $user = User::factory()->createOne();
        $product = Product::factory()->createOne();

        $this->actingAs($user, 'sanctum');

        $addResponse = $this->postJson('/api/cart', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $cartItemId = $addResponse->json('id');

        $removeResponse = $this->deleteJson("/api/cart/{$cartItemId}");

        $removeResponse->assertStatus(200);
    }
}
