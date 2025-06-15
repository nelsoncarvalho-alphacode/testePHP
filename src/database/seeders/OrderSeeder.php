<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            ['client_id' => 1, 'product_id' => 15, 'quantity' => 2, 'status' => 'payed', 'order_date' => '2024-01-15', 'discount' => 0.10],
            ['client_id' => 2, 'product_id' => 8, 'quantity' => 1, 'status' => 'pending', 'order_date' => '2024-01-18', 'discount' => null],
            ['client_id' => 3, 'product_id' => 23, 'quantity' => 3, 'status' => 'payed', 'order_date' => '2024-01-20', 'discount' => 0.15],
            ['client_id' => 4, 'product_id' => 5, 'quantity' => 1, 'status' => 'canceled', 'order_date' => '2024-01-22', 'discount' => null],
            ['client_id' => 5, 'product_id' => 31, 'quantity' => 2, 'status' => 'payed', 'order_date' => '2024-01-25', 'discount' => 0.05],
            ['client_id' => 6, 'product_id' => 12, 'quantity' => 4, 'status' => 'pending', 'order_date' => '2024-01-28', 'discount' => null],
            ['client_id' => 7, 'product_id' => 2, 'quantity' => 1, 'status' => 'payed', 'order_date' => '2024-02-02', 'discount' => 0.20],
            ['client_id' => 8, 'product_id' => 19, 'quantity' => 2, 'status' => 'payed', 'order_date' => '2024-02-05', 'discount' => null],
            ['client_id' => 9, 'product_id' => 7, 'quantity' => 3, 'status' => 'canceled', 'order_date' => '2024-02-08', 'discount' => null],
            ['client_id' => 10, 'product_id' => 26, 'quantity' => 1, 'status' => 'pending', 'order_date' => '2024-02-12', 'discount' => 0.12],
            ['client_id' => 11, 'product_id' => 14, 'quantity' => 2, 'status' => 'payed', 'order_date' => '2024-02-15', 'discount' => null],
            ['client_id' => 12, 'product_id' => 33, 'quantity' => 5, 'status' => 'payed', 'order_date' => '2024-02-18', 'discount' => 0.25],
            ['client_id' => 13, 'product_id' => 4, 'quantity' => 1, 'status' => 'pending', 'order_date' => '2024-02-22', 'discount' => null],
            ['client_id' => 14, 'product_id' => 29, 'quantity' => 2, 'status' => 'canceled', 'order_date' => '2024-02-25', 'discount' => null],
            ['client_id' => 15, 'product_id' => 17, 'quantity' => 3, 'status' => 'payed', 'order_date' => '2024-02-28', 'discount' => 0.08],
            ['client_id' => 16, 'product_id' => 9, 'quantity' => 1, 'status' => 'pending', 'order_date' => '2024-03-03', 'discount' => null],
            ['client_id' => 17, 'product_id' => 35, 'quantity' => 2, 'status' => 'payed', 'order_date' => '2024-03-06', 'discount' => 0.30],
            ['client_id' => 18, 'product_id' => 21, 'quantity' => 4, 'status' => 'payed', 'order_date' => '2024-03-10', 'discount' => null],
            ['client_id' => 19, 'product_id' => 6, 'quantity' => 1, 'status' => 'canceled', 'order_date' => '2024-03-13', 'discount' => null],
            ['client_id' => 20, 'product_id' => 38, 'quantity' => 3, 'status' => 'pending', 'order_date' => '2024-03-16', 'discount' => 0.18],
            ['client_id' => 21, 'product_id' => 11, 'quantity' => 2, 'status' => 'payed', 'order_date' => '2024-03-20', 'discount' => null],
            ['client_id' => 22, 'product_id' => 24, 'quantity' => 1, 'status' => 'payed', 'order_date' => '2024-03-23', 'discount' => 0.22],
            ['client_id' => 23, 'product_id' => 3, 'quantity' => 5, 'status' => 'pending', 'order_date' => '2024-03-26', 'discount' => null],
            ['client_id' => 24, 'product_id' => 16, 'quantity' => 2, 'status' => 'canceled', 'order_date' => '2024-03-29', 'discount' => null],
            ['client_id' => 25, 'product_id' => 40, 'quantity' => 1, 'status' => 'payed', 'order_date' => '2024-04-02', 'discount' => 0.35],
            ['client_id' => 26, 'product_id' => 13, 'quantity' => 3, 'status' => 'pending', 'order_date' => '2024-04-05', 'discount' => null],
            ['client_id' => 27, 'product_id' => 27, 'quantity' => 2, 'status' => 'payed', 'order_date' => '2024-04-08', 'discount' => 0.14],
            ['client_id' => 28, 'product_id' => 1, 'quantity' => 1, 'status' => 'payed', 'order_date' => '2024-04-12', 'discount' => null],
            ['client_id' => 29, 'product_id' => 32, 'quantity' => 4, 'status' => 'canceled', 'order_date' => '2024-04-15', 'discount' => null],
            ['client_id' => 30, 'product_id' => 18, 'quantity' => 2, 'status' => 'pending', 'order_date' => '2024-04-18', 'discount' => 0.28],
            ['client_id' => 31, 'product_id' => 22, 'quantity' => 1, 'status' => 'payed', 'order_date' => '2024-04-22', 'discount' => null],
            ['client_id' => 32, 'product_id' => 10, 'quantity' => 3, 'status' => 'payed', 'order_date' => '2024-04-25', 'discount' => 0.40],
            ['client_id' => 33, 'product_id' => 36, 'quantity' => 2, 'status' => 'pending', 'order_date' => '2024-04-28', 'discount' => null],
            ['client_id' => 34, 'product_id' => 25, 'quantity' => 1, 'status' => 'canceled', 'order_date' => '2024-05-02', 'discount' => null],
            ['client_id' => 35, 'product_id' => 39, 'quantity' => 5, 'status' => 'payed', 'order_date' => '2024-05-05', 'discount' => 0.45],
            ['client_id' => 36, 'product_id' => 20, 'quantity' => 2, 'status' => 'pending', 'order_date' => '2024-05-08', 'discount' => null],
            ['client_id' => 37, 'product_id' => 28, 'quantity' => 1, 'status' => 'payed', 'order_date' => '2024-05-12', 'discount' => 0.07],
            ['client_id' => 38, 'product_id' => 34, 'quantity' => 3, 'status' => 'payed', 'order_date' => '2024-05-15', 'discount' => null],
            ['client_id' => 39, 'product_id' => 30, 'quantity' => 2, 'status' => 'canceled', 'order_date' => '2024-05-18', 'discount' => null],
            ['client_id' => 40, 'product_id' => 37, 'quantity' => 1, 'status' => 'pending', 'order_date' => '2024-05-22', 'discount' => 0.33],
        ]);
    }
}
