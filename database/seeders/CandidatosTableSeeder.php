<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CandidatosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('candidatos')->insert([
            // rows
            [
                'name' => 'Lucas',
                'username' => 'lucas@gmail.com',
                'password' => bcrypt('123456')
            ],
        ]);
    }
}
