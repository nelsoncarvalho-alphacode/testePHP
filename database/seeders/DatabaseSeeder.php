<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Client;
use App\Models\Product;
use App\Models\PurchaseRequest;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Client::factory(100)->create();
        $this->call(StatusSeeder::class);
        Product::factory(100)->create();
        PurchaseRequest::factory(50)->create();

    }
}
