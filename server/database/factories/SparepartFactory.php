<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sparepart>
 */
class SparepartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(2),
            'price' => fake()->numberBetween(10000, 100000),
            'stok' => fake()->numberBetween(5, 50),
            'image' => fake()->imageUrl(),
            'category_id' => fake()->numberBetween(1, 10),
        ];
    }
}
