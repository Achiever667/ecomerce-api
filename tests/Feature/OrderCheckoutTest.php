<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderCheckoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_checkout_order()
    {
        $user = User::factory()->createOne();

        $product = Product::factory()->create([
            'price' => 50.00,
        ]);

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/checkout');

        $response->assertStatus(201)
            ->assertJsonStructure(['message', 'order' => ['id', 'user_id', 'status', 'total', 'created_at', 'updated_at']]);
    }
}
