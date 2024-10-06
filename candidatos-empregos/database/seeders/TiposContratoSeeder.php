<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        DB::table('tipo_contrato')->insert([
            'tipo' => 'CLT',
        ]);

        DB::table('tipo_contrato')->insert([
            'tipo' => 'Pessoa Jurídica',
        ]);

        DB::table('tipo_contrato')->insert([
            'tipo' => 'Freelancer',
        ]);
    }
}
