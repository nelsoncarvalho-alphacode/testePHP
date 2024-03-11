<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Smartphone',
                'quantity' => 10,
                'description' => 'Aparelho de comunicação móvel',
                'price' => 1999.99,
                'barcode' => '123456789',
                'status' => 1,
                'categorie_id' => 1,
            ],
            [
                'name' => 'Geladeira',
                'quantity' => 5,
                'description' => 'Eletrodoméstico para refrigeração de alimentos',
                'price' => 2999.99,
                'barcode' => '987654321',
                'status' => 1,
                'categorie_id' => 2,
            ],
            [
                'name' => 'Cadeira',
                'quantity' => 20,
                'description' => 'Móvel para sentar',
                'price' => 199.99,
                'barcode' => '123123123',
                'status' => 1,
                'categorie_id' => 3,
            ],
            [
                'name' => 'Notebook',
                'quantity' => 15,
                'description' => 'Computador portátil',
                'price' => 3999.99,
                'barcode' => '456456456',
                'status' => 1,
                'categorie_id' => 1,
            ],
            [
                'name' => 'Pneu',
                'quantity' => 50,
                'description' => 'Pneu para automóveis',
                'price' => 499.99,
                'barcode' => '789789789',
                'status' => 1,
                'categorie_id' => 4,
            ],
            [
                'name' => 'Bola de futebol',
                'quantity' => 30,
                'description' => 'Bola para prática de futebol',
                'price' => 99.99,
                'barcode' => '654654654',
                'status' => 1,
                'categorie_id' => 5,
            ],
            [
                'name' => 'Camiseta',
                'quantity' => 100,
                'description' => 'Vestuário',
                'price' => 49.99,
                'barcode' => '321321321',
                'status' => 1,
                'categorie_id' => 6,
            ],
            [
                'name' => 'Tênis',
                'quantity' => 80,
                'description' => 'Calçado',
                'price' => 199.99,
                'barcode' => '987987987',
                'status' => 1,
                'categorie_id' => 6,
            ],
            [
                'name' => 'Carrinho de controle remoto',
                'quantity' => 40,
                'description' => 'Brinquedo',
                'price' => 149.99,
                'barcode' => '654321654',
                'status' => 1,
                'categorie_id' => 7,
            ],
            [
                'name' => 'Relógio',
                'quantity' => 60,
                'description' => 'Acessório de moda',
                'price' => 299.99,
                'barcode' => '321654321',
                'status' => 1,
                'categorie_id' => 6,
            ],
            [
                'name' => 'Arroz',
                'quantity' => 200,
                'description' => 'Alimento',
                'price' => 19.99,
                'barcode' => '987654321',
                'status' => 1,
                'categorie_id' => 8,
            ],
            [
                'name' => 'Feijão',
                'quantity' => 150,
                'description' => 'Alimento',
                'price' => 9.99,
                'barcode' => '123456789',
                'status' => 1,
                'categorie_id' => 8,
            ],
        ];

        foreach ($products as $product) {
            \App\Models\Product::create($product);
        }
    }
}
