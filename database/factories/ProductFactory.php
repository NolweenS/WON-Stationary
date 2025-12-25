<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class ProductFactory extends Factory
{
public function definition():array
{
    //eerst een naam genereren zodat we het voor de 'slug' onderdeel kunnen hergebruiken
    $name = fake()->unique()->words(rand(2,4),true);
    return
        [
            'category_id' => Category::factory(),
            'name'=>ucfirst($name),
            'slug'=>Str::slug($name),
            'description' => fake()->paragraph(3),
            'price' => fake()->randomFloat(2, 5, 500),
            'image' => null,
            'stock' => fake()->numberBetween(0, 50),
            'is_featured' => fake()->boolean(10),

        ];
}
}
