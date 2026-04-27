<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
        'name' => $this->faker->word(),
        'description' => $this->faker->sentence(),
        'price' => $this->faker->numberBetween(1000, 100000),
        'image' => null,
    ];
}
}
