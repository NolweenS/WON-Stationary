<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Planners',
                'description' => 'Luxe planners voor een georganiseerd leven.',
                'icon' => 'bi-calendar3' // Voorbeeld van icoon klasse voor categorie
            ],
            [
                'name' => 'Notebooks',
                'description' => 'Leg je gedachten vast in stijl.',
                'icon' => 'bi-book'
            ],
            [
                'name' => 'Pens & Crayons',
                'description' => 'Schrijfcomfort ontmoet design.',
                'icon' => 'bi-pencil'
            ],
            [
                'name' => 'Stickers',
                'description' => 'Geef je journals een persoonlijke touch.',
                'icon' => 'bi-sticky'
            ],
            [
                'name' => 'Accessoires',
                'description' => 'De finishing touch voor je bureau.',
                'icon' => 'bi-paperclip'
            ],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'],
                'image' => $cat['icon'],
            ]);
        }
    }
}
