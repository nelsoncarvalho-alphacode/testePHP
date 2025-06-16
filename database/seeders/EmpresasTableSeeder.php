<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('empresas')->insert([
            // rows
            [
                'name' => 'alphacode',
                'username' => 'rh@alphacode.com',
                'password' => bcrypt('123456')
            ],
        ]);
    }
}
