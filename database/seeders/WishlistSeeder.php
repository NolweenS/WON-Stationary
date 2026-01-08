<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class WishlistSeeder extends Seeder
{
    public function run(): void
    {
        // Haal de gebruikers op
        $emma = User::where('email', 'emma@example.com')->first();
        $liam = User::where('email', 'liam@example.com')->first();

        // Haal de producten op
        $planner = Product::where('name', 'LIKE', '%Planner%')->first();
        $sticker = Product::where('name', 'LIKE', '%Sticker%')->first();

        // Gebruik de relatie uit User model
        if ($emma && $planner) {
            $emma->wishlist()->attach($planner->id);
        }

        if ($emma && $sticker) {
            $emma->wishlist()->attach($sticker->id);
        }

        if ($liam && $planner) {
            $liam->wishlist()->attach($planner->id);
        }
    }
}
