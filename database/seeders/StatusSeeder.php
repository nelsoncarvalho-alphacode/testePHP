<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statusData = [
            ['id' => 1, 'name' => 'Em Aberto'],
            ['id' => 2, 'name' => 'Pago'],
            ['id' => 3, 'name' => 'Cancelado'],
        ];

        foreach ($statusData as $data) {
            Status::updateOrCreate(['id' => $data['id']], $data);
        }
    }
}
