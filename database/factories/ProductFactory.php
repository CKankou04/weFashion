<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //creons un titre(6mots par defauts) et un paragraphe(3par defaut)
            'name' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 5, 2000),
            'stateProduct' => $this->faker->randomElement(['sale', 'standard']),
            'isVisible' => $this->faker->randomElement(['publish', 'unpublish']),
            'referenceProduct' => Str::random(16)
        ];
    }
}
