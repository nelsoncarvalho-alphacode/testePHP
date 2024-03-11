<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categorie>
 */
class CategorieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create();

        $categories = [
            'textile' => ['Tecido', 'Roupas e Acessórios', 'Moda'],
            'appliance' => ['Eletrodoméstico', 'Eletroportátil', 'Utensílios Domésticos'],
            'electronics' => ['Eletrônico', 'Tecnologia', 'Informática'],
            'construction' => ['Material de Construção', 'Ferramentas', 'Acabamentos'],
        ];

        $usedCategories = [];

        do {
            $industry = $faker->randomElement(array_keys($categories));
            $name = $faker->randomElement($categories[$industry]);
            $description = $faker->sentence;
        } while (in_array($name, $usedCategories));

        $usedCategories[] = $name;

        return [
            'name' => $name,
            'description' => $description,
        ];
    }
}
