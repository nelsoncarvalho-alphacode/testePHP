<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    protected $model = Produto::class;

    public function definition()
    {
        return [
            'cod_barras' => $this->faker->unique()->ean13(),
            'nome' => $this->faker->words(3, true),
            'valor_unitario' => $this->faker->randomFloat(2, 1, 1000)
        ];
    }
}