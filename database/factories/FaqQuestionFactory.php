<?php

namespace Database\Factories;

use App\Models\FaqQuestion;
use App\Models\FaqCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = FaqQuestion::class;
    public function definition(): array
    {
        return [
            'faq_category_id' => FaqCategory::factory(),
            'question'=>fake()->sentence() . '?',
            'answer'=>fake()->paragraph(),

        ];
    }
}
