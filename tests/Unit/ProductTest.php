<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        $product = new Product();

        $this->assertEquals(['name', 'price', 'description', 'image', 'category'], $product->getFillable());
    }
}
