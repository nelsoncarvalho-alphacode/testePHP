<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseOrder>
 */
class PurchaseOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => \App\Models\Client::factory(),
            'total' => $this->faker->randomFloat(2, 0, 1000),
            'status' => $this->faker->randomElement(['Em Aberto', 'Pago', 'Cancelado']),
            'payment_method' => $this->faker->randomElement(['credito', 'debito', 'pix']),
            'order_date' => $this->faker->date,
            'order_number' => $this->faker->unique()->numerify('##########'),
        ];
    }
}
