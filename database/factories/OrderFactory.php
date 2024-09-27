<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'order_number' => $this->faker->unique()->numberBetween(1000, 9999),
            'client_id' => Client::factory(),
            'order_status' => $this->faker->randomElement(['Open', 'Paid', 'Cancelled']),
            'total_amount' => 0,
            'discount' => $this->faker->randomFloat(2, 0, 20),
        ];
    }
}
