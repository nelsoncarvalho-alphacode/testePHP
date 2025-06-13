<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    protected $model = Pedido::class;

    public function definition()
    {
        return [
            'cliente_id' => Cliente::factory(),
            'data_pedido' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'status' => $this->faker->randomElement(['Em Aberto', 'Pago', 'Cancelado']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Pedido $pedido) {
            $produtos = Produto::factory()
                ->count($this->faker->numberBetween(1, 5))
                ->create();

            $total = 0;

            foreach ($produtos as $produto) {
                $quantidade = $this->faker->numberBetween(1, 10);
                $valorUnitario = $produto->valor_unitario;

                $pedido->produtos()->attach($produto->id, [
                    'quantidade' => $quantidade,
                    'valor_unitario' => $valorUnitario,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $total += $quantidade * $valorUnitario;
            }

            $pedido->update(['total' => $total]);
        });
    }
}