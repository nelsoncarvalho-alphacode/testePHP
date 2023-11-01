<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Product;
use App\Models\PurchaseRequest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class PurchaseRequestFactory extends Factory
{
    protected $model = PurchaseRequest::class;

    public function definition(): array
    {
        $faker = FakerFactory::create();
        $client = Client::inRandomOrder()->first();
        $product = Product::inRandomOrder()->first();
        $status = 1;
        $amount = $faker->numberBetween(1, $product->amount);
        $percentage = $faker->numberBetween(0, 18);

        return [
            'id_client' => $client->id,
            'id_product' => $product->id,
            'id_status' => $status,
            'value_unit' => $product->value,
            'amount_Buy' => $amount,
            'percentage_descount' => $percentage,
            'amount_Buy_descount' => (($product->value * $amount) * ($percentage / 100)),
        ];
    }
}
