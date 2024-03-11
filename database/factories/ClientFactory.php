<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

require_once 'vendor/autoload.php';

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'cpf' => $this->faker->unique()->numerify('###########'),
            'celphone' => $this->faker->phoneNumber,
            'celphone' => $this->faker->regexify('/\d{2}\d{9}/'),
            'date_of_birth' => $this->faker->date,
            'password' => Hash::make('password'),
            'cep' => $this->faker->numerify('########'),
            'address' => $this->faker->streetName,
            'addressNumber' => $this->faker->numberBetween(1, 9999),
            'complement' => $this->faker->secondaryAddress,
            'neighborhood' => $this->faker->citySuffix,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
        ];
    }
}