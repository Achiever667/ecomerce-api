<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => 1, // Adjust as needed or use factory relationship
            'status' => 'pending',
            'total' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
