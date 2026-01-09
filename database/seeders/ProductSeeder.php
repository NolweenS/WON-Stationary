<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        //Definieer de producten per categorie
        $inventory = [
            'Planners' => [
                ['name' => 'Luxe Planner 1', 'img' => 'planner1.jpg', 'price' => 19.95],
                ['name' => 'Week Planner 2', 'img' => 'planner2.jpg', 'price' => 24.50],
                ['name' => 'Dag Planner 3', 'img' => 'planner3.jpg', 'price' => 29.95],
                ['name' => 'Compact Planner 4', 'img' => 'planner1.jpg', 'price' => 15.00],
            ],
            'Notebooks' => [
                ['name' => 'Notebook Geliniieerd 1', 'img' => 'notebook1.jpg', 'price' => 12.50],
                ['name' => 'Notebook Blanco 2', 'img' => 'notebook2.jpg', 'price' => 14.95],
                ['name' => 'Notebook Gestippeld 3', 'img' => 'notebook3.jpg', 'price' => 18.00],
                ['name' => 'Softcover Notebook 4', 'img' => 'notebook1.jpg', 'price' => 10.00],
            ],
            'Pens & Crayons' => [
                ['name' => 'Balpennen Set 1', 'img' => 'pens1.jpg', 'price' => 4.50],
                ['name' => 'Kleurpotloden Set 2', 'img' => 'pens2.jpg', 'price' => 5.95],
                ['name' => 'Grafiet Potlood', 'img' => 'pencil.jpg', 'price' => 1.50],
                ['name' => 'Luxe Pen 4', 'img' => 'pens1.jpg', 'price' => 8.00],
            ],
            'Stickers' => [
                ['name' => 'Sticker Pakket 1', 'img' => 'stickers1.jpg', 'price' => 3.50],
                ['name' => 'Planner Stickers 2', 'img' => 'stickers2.jpg', 'price' => 4.25],
                ['name' => 'Decoratie Stickers 3', 'img' => 'stickers3.jpg', 'price' => 2.95],
                ['name' => 'Alfabet Stickers 4', 'img' => 'stickers1.jpg', 'price' => 3.00],
            ],
            'Accessoires' => [
                ['name' => 'RVS Schaar', 'img' => 'acc1.jpg', 'price' => 6.50],
                ['name' => 'Correctie Roller', 'img' => 'acc2.jpg', 'price' => 3.95],
                ['name' => 'Leren Pennenzak', 'img' => 'acc3.jpg', 'price' => 12.50],
                ['name' => 'Bureau Organizer 4', 'img' => 'acc1.jpg', 'price' => 9.95],
            ],
        ];

        foreach ($inventory as $categoryName => $products) {
            $category = Category::where('name', $categoryName)->first();

            if ($category) {
                foreach ($products as $p) {
                    // Gebruik updateOrCreate in plaats van create
                    Product::updateOrCreate(
                        ['slug' => Str::slug($p['name'])], // Check of deze slug al bestaat
                        [
                            'category_id' => $category->id,
                            'name' => $p['name'],
                            'description' => 'Een prachtig item uit onze ' . $categoryName . ' collectie. Perfect voor een georganiseerd bureau.',
                            'price' => $p['price'],
                            'stock' => rand(10, 100),
                            'image' => $p['img'],
                        ]
                    );
                }
            }
        }
    }
}
