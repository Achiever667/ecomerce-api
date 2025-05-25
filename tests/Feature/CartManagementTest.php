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
        $product = Product::factory()->create();

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/cart', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment(['product_id' => $product->id, 'quantity' => 1]);
    }

    /** @test */
    public function user_can_view_cart()
    {
        $user = User::factory()->createOne();
        $product = Product::factory()->create();

        $this->actingAs($user, 'sanctum');

        $this->postJson('/api/cart', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->getJson('/api/cart');

        $response->assertStatus(200)
            ->assertJsonFragment(['product_id' => $product->id]);
    }

    /** @test */
    public function user_can_remove_product_from_cart()
    {
        $user = User::factory()->createOne();
        $product = Product::factory()->create();

        $this->actingAs($user, 'sanctum');

        $addResponse = $this->postJson('/api/cart', [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $cartItemId = $addResponse->json('id');

        $response = $this->deleteJson("/api/cart/{$cartItemId}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Product removed from cart']);
    }
}
