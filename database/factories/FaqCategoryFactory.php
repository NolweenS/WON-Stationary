<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\FaqCategory;

class FaqCategoryFactory extends Factory
{
    protected $model = FaqCategory::class;
    public function definition() : array
    {
        $name = $this->faker->unique()->word();
        return [
            'name'=>fake()->unique()->word,
            'slug'=>Str::slug($name),
        ];
    }
}
