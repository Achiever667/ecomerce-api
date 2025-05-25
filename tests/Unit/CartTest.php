<?php

namespace Tests\Unit;

use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        $cart = new Cart();

        $this->assertEquals(['user_id', 'product_id', 'quantity'], $cart->getFillable());
    }
}
