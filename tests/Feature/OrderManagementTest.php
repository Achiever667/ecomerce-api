<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_their_order_history()
    {
        $user = User::factory()->createOne();

        $this->actingAs($user, 'sanctum');

        $response = $this->getJson('/api/orders');

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_view_all_orders()
    {
        $admin = User::factory()->createOne();

        $this->actingAs($admin, 'sanctum');

        $response = $this->getJson('/api/admin/orders');

        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_update_order_status()
    {
        $admin = User::factory()->createOne();

        $order = Order::factory()->create();

        $this->actingAs($admin, 'sanctum');

        $response = $this->putJson("/api/admin/orders/{$order->id}/status", [
            'status' => 'shipped',
        ]);

        $response->assertStatus(200)
            ->assertJsonFragment(['status' => 'shipped']);
    }
}
