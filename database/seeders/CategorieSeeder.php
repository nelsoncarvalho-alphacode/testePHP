<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Eletrônicos', 'description' => 'Categoria de produtos eletrônicos.'],
            ['name' => 'Eletrodomésticos', 'description' => 'Categoria de eletrodomésticos para o lar.'],
            ['name' => 'Móveis', 'description' => 'Categoria de móveis para casa e escritório.'],
            ['name' => 'Automotivo', 'description' => 'Categoria de produtos automotivos.'],
            ['name' => 'Esportes', 'description' => 'Categoria de produtos esportivos.'],
            ['name' => 'Moda', 'description' => 'Categoria de roupas, calçados e acessórios de moda.'],
            ['name' => 'Brinquedos', 'description' => 'Categoria de brinquedos para crianças.'],
            ['name' => 'Alimentos', 'description' => 'Categoria de alimentos e produtos alimentícios.'],
        ];

        foreach ($categories as $category) {
            \App\Models\Categorie::create($category);
        }
    }
}
