<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Candidato;
use App\Models\Vaga;
use App\Models\Inscricao;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $candidatos = Candidato::factory(10)->create();
        $vagas      = Vaga::factory(5)->create();

        // Cria inscrições aleatórias
        foreach ($candidatos as $candidato) {
            $candidato->vagas()->attach(
                $vagas->random(rand(1, 3))->pluck('id')->toArray(),
                ['data_inscricao' => now()]
            );
    }
}

 }
