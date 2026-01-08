<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // We halen de categorieën op die we in de CategorySeeder hebben gemaakt
        $categories = Category::all();

        // Configuratie van foto's per categorie
        $productData = [
            'Planners' => [
                'images' => ['planner1.jpg', 'planner2.jpg', 'planner3.jpg'],
                'min' => 19.95, 'max' => 34.95
            ],
            'Notebooks' => [
                'images' => ['notebook1.jpg', 'notebook2.jpg', 'notebook3.jpg'],
                'min' => 12.50, 'max' => 24.95
            ],
            'Pens & Crayons' => [
                'images' => ['pens1.jpg', 'pens2.jpg', 'pencil.jpg'],
                'min' => 2.95, 'max' => 5.00
            ],
            'Stickers' => [
                'images' => ['stickers1.jpg', 'stickers2.jpg', 'stickers3.jpg'],
                'min' => 1.50, 'max' => 5.95
            ],
            'Accessoires' => [
                'images' => ['acc1.jpg', 'acc2.jpg', 'acc3.jpg'],
                'min' => 4.95, 'max' => 10.00
            ],
        ];

        foreach ($categories as $category) {
            // We maken 4 producten per categorie aan
            for ($i = 1; $i <= 4; $i++) {
                $config = $productData[$category->name];

                Product::create([
                    'category_id' => $category->id,
                    'name' => $category->name . ' ' . $i,
                    'slug' => str()->slug($category->name . '-' . $i),
                    'description' => 'Een prachtig item uit onze ' . $category->name . ' collectie. Perfect voor een georganiseerd bureau.',
                    'price' => fake()->randomFloat(2, $config['min'], $config['max']),
                    'stock' => rand(5, 50),
                    // Pad naar de afbeeldingen
                    'image' => 'images/placeholder/' . $config['images'][array_rand($config['images'])],
                ]);
            }
        }
    }
}
