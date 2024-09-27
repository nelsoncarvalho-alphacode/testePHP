<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Gerar 10 clientes
        $clients = Client::factory(10)->create();

        // Gerar 30 produtos
        $products = Product::factory(30)->create();

        // Gerar 50 pedidos
        $orders = Order::factory(50)->create()->each(function ($order) use ($products) {
            $totalAmount = 0;
            $productCount = rand(1, 5);
            for ($j = 0; $j < $productCount; $j++) {
                $product = $products->random();
                $quantity = rand(1, 10);
                $totalAmount += $product->unit_price * $quantity;
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->product_name,
                    'barcode' => $product->barcode,
                    'unit_price' => $product->unit_price,
                    'quantity' => $quantity,
                ]);
            }

            // Atualiza o total_amount do pedido
            $order->update([
                'total_amount' => $totalAmount - $order->discount,
            ]);
        });
    }
}
