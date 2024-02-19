<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;
use App\Models\Produto;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Produto::all()->random();
        if($product->qtd_prod > 0){
            return [
                'cliente_id' => Cliente::all()->random()->id,
                'id_produto'=> $product->id,
                'quantidade_prod_pedido' =>  1
            ];
        }

        return[];
    }
}
