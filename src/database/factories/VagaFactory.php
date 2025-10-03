<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vaga>
 */
class VagaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo'    => $this->faker->jobTitle(),
            'descricao' => $this->faker->sentence(8),
            'tipo'      => $this->faker->randomElement(['CLT','PJ','Freelancer']),
            'status'    => $this->faker->randomElement(['ativa','pausada']),
            'salario'   => $this->faker->randomFloat(2, 2000, 10000),
        ];
    }
}
