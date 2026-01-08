<?php

namespace Database\Seeders;

use App\Models\FaqCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FaqCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Bestellingen',
            'Betalingen',
            'Verzending',
            'Retourneren & Ruilen'
        ];

        foreach ($categories as $name) {
            FaqCategory::create([
                'name' => $name,
                'slug' => Str::slug($name) // Dit genereert 'bestellingen', 'verzending'
            ]);
        }
    }
}
