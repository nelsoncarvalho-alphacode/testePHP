<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'barcode' => $this->faker->unique()->numerify('#############'),
            'product_name' => $this->faker->word,
            'unit_price' => $this->faker->randomFloat(2, 5, 100),
        ];
    }
}
