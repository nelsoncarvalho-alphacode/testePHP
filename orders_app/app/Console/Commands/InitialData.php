<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;

class InitialData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando a inserção de dados');

        $faker = Factory::create('pt-BR');

        // CRIANDO USUÁRIO PRINCIPAL
        User::create([
            'name' => 'Sysadmin',
            'email' => 'sysadmin@mail.com',
            'password' => Hash::make('abcd@1234'),
            'email_verified_at' => now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        // CRIANDO CLIENTES
        $qtd_clients = 8;
        for($i = 0; $i <= $qtd_clients; $i++){
            Client::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'cpf' => '12345678987'
            ]);
        }

        // CRIANDO PRODUTOS
        $qtd_products = 4;
        for($j = 0; $j <= $qtd_products; $j++){
            Product::create([
                'name' => $faker->randomElement(['Pizza', 'Sanduiche', 'Pastel', 'Açai', 'Água']),
                'price' => rand(10, 25),
                'barcode' => $faker->ean13
            ]);
        }

        // CRIANDO PEDIDOS
        $qtd_orders = 5;
        for($k = 0; $k <= $qtd_orders; $k++){
            $rand_clients = Client::all()->random();
            $rand_products = Product::all()->random();
            Order::create([
                'client_id' => $rand_clients->id,
                'product_id' => $rand_products->id,
                'quantity' => rand(1, 10),
                'status' => $faker->randomElement(['Em Aberto', 'Pago', 'Cancelado']),
                'promotion' => rand(0, 25)
            ]);
        }
    }
}
