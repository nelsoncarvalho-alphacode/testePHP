<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VagasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vagas')->insert([
            // rows
            [   
                'empresa_id' => 1,
                'title' => 'Desenvolvedor Junior PHP',
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis neque voluptatibus nam quisquam, corporis adipisci iure quidem debitis ab sapiente sint illum expedita beatae, blanditiis cum recusandae autem at optio.',
                'regime' => 'clt'
            ]
        ]);
    }
}
