<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            ['name' => 'Smartphone Samsung Galaxy A54', 'price' => 1299.90, 'barcode' => '7891234567890'],
            ['name' => 'Notebook Dell Inspiron 15', 'price' => 2899.99, 'barcode' => '7891234567891'],
            ['name' => 'Mouse Logitech MX Master 3', 'price' => 329.90, 'barcode' => '7891234567892'],
            ['name' => 'Teclado Mecânico Corsair K70', 'price' => 599.90, 'barcode' => '7891234567893'],
            ['name' => 'Monitor LG UltraWide 29"', 'price' => 1199.90, 'barcode' => '7891234567894'],
            ['name' => 'Headset HyperX Cloud II', 'price' => 399.90, 'barcode' => '7891234567895'],
            ['name' => 'SSD Kingston 480GB', 'price' => 249.90, 'barcode' => '7891234567896'],
            ['name' => 'Memória RAM Corsair 16GB', 'price' => 399.90, 'barcode' => '7891234567897'],
            ['name' => 'Placa de Vídeo GTX 1660', 'price' => 1899.90, 'barcode' => '7891234567898'],
            ['name' => 'Processador AMD Ryzen 5', 'price' => 899.90, 'barcode' => '7891234567899'],
            ['name' => 'Cafeteira Nespresso Essenza', 'price' => 299.90, 'barcode' => '7891234567800'],
            ['name' => 'Aspirador de Pó Electrolux', 'price' => 349.90, 'barcode' => '7891234567801'],
            ['name' => 'Geladeira Brastemp Frost Free 400L', 'price' => 2199.90, 'barcode' => '7891234567802'],
            ['name' => 'Micro-ondas Panasonic 32L', 'price' => 599.90, 'barcode' => '7891234567803'],
            ['name' => 'Smart TV Samsung 55" 4K', 'price' => 2399.90, 'barcode' => '7891234567804'],
            ['name' => 'Air Fryer Philco 3.2L', 'price' => 199.90, 'barcode' => '7891234567805'],
            ['name' => 'Liquidificador Oster 600W', 'price' => 149.90, 'barcode' => '7891234567806'],
            ['name' => 'Ferro de Passar Philips Steam', 'price' => 89.90, 'barcode' => '7891234567807'],
            ['name' => 'Ventilador de Mesa Arno', 'price' => 129.90, 'barcode' => '7891234567808'],
            ['name' => 'Bicicleta Caloi Elite 29"', 'price' => 1899.90, 'barcode' => '7891234567809'],
            ['name' => 'Tênis Nike Air Max 270', 'price' => 499.90, 'barcode' => '7891234567810'],
            ['name' => 'Camiseta Adidas Originals', 'price' => 99.90, 'barcode' => '7891234567811'],
            ['name' => 'Calça Jeans Levi\'s 501', 'price' => 299.90, 'barcode' => '7891234567812'],
            ['name' => 'Relógio Casio G-Shock', 'price' => 399.90, 'barcode' => '7891234567813'],
            ['name' => 'Óculos de Sol Ray-Ban Aviator', 'price' => 599.90, 'barcode' => '7891234567814'],
            ['name' => 'Mochila JanSport SuperBreak', 'price' => 149.90, 'barcode' => '7891234567815'],
            ['name' => 'Livro "Dom Casmurro" Machado de Assis', 'price' => 24.90, 'barcode' => '7891234567816'],
            ['name' => 'Caderno Universitário Tilibra 200 Folhas', 'price' => 19.90, 'barcode' => '7891234567817'],
            ['name' => 'Caneta BIC Cristal Azul (Pack 10)', 'price' => 12.90, 'barcode' => '7891234567818'],
            ['name' => 'Lápis Faber-Castell HB (Pack 12)', 'price' => 15.90, 'barcode' => '7891234567819'],
            ['name' => 'Perfume Natura Kaiak Masculino', 'price' => 89.90, 'barcode' => '7891234567820'],
            ['name' => 'Shampoo L\'Oréal Elseve 400ml', 'price' => 18.90, 'barcode' => '7891234567821'],
            ['name' => 'Creme Dental Colgate Total 12', 'price' => 8.90, 'barcode' => '7891234567822'],
            ['name' => 'Sabonete Dove Original 90g', 'price' => 3.90, 'barcode' => '7891234567823'],
            ['name' => 'Detergente Ypê Neutro 500ml', 'price' => 2.90, 'barcode' => '7891234567824'],
            ['name' => 'Papel Higiênico Neve Folha Dupla (Pack 12)', 'price' => 24.90, 'barcode' => '7891234567825'],
            ['name' => 'Refrigerante Coca-Cola 2L', 'price' => 7.90, 'barcode' => '7891234567826'],
            ['name' => 'Água Mineral Crystal 1.5L', 'price' => 2.50, 'barcode' => '7891234567827'],
            ['name' => 'Chocolate Bis ao Leite 126g', 'price' => 6.90, 'barcode' => '7891234567828'],
            ['name' => 'Café Pilão Torrado e Moído 500g', 'price' => 14.90, 'barcode' => '7891234567829'],
        ]);
    }
}
