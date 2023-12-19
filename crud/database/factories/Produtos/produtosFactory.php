<?php

namespace Database\Factories\Produtos;


use App\Models\Produtos\produtos;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Models\Produtos\produtos>
 */
class produtosFactory extends Factory
{
    protected $model = produtos::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo_barras' => $this->faker->unique()->randomNumber(9, true),
            'nome' => $this->faker->word,
            'quantidade' => $this->faker->numberBetween(1, 100),
            'valor_unitario' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
