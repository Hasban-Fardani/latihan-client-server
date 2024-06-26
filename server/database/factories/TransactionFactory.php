<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => fake()->numberBetween(1, 10),
            'user_id' => fake()->numberBetween(1, 10),
            'total' => fake()->numberBetween(100000, 1000000),
            'date' => fake()->randomElement([
                '2024-04-26',
                '2024-04-27',
                '2024-04-28',
                '2024-04-29',
                '2024-04-30',
            ]),
        ];
    }
}
