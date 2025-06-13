<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Cliente::factory(20)->create();

        \App\Models\Produto::factory(50)->create();

        \App\Models\Pedido::factory(30)->create();
    }
}