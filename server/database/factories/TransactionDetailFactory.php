<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionDetail>
 */
class TransactionDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_id' => fake()->numberBetween(1, 10),
            'sparepart_id' => fake()->numberBetween(1, 10),
            'qty' => fake()->numberBetween(1, 10),
            'subtotal' => fake()->numberBetween(30000, 1000000)
        ];
    }
}
