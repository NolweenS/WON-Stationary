<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating'=>fake()->numberBetween(1,5),
            'comment'=>fake()->boolean(80) ? fake()->paragraph(): null,
            'created_at'=>fake()->dateTime('-1year','now'),
        ];
    }
}
