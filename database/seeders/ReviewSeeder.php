<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Haal de gebruikers op
        $emma = User::where('email', 'emma@example.com')->first();
        $liam = User::where('email', 'liam@example.com')->first();

        // Haal specifieke producten op voor de reviews
        $planner = Product::where('name', 'LIKE', '%Planner%')->first();
        $notebook = Product::where('name', 'LIKE', '%Notebook%')->first();

        if ($emma && $planner) {
            Review::create([
                'user_id' => $emma->id,
                'product_id' => $planner->id,
                'rating' => 5,
                'comment' => 'Deze planner heeft mijn leven veranderd! De nude kleuren zijn prachtig.',
            ]);
        }

        if ($liam && $notebook) {
            Review::create([
                'user_id' => $liam->id,
                'product_id' => $notebook->id,
                'rating' => 4,
                'comment' => 'Heel fijn papier om op te schrijven, vlekt niet met mijn vulpen.',
            ]);
        }

        if ($emma && $notebook) {
            Review::create([
                'user_id' => $emma->id,
                'product_id' => $notebook->id,
                'rating' => 5,
                'comment' => 'Ik heb deze cadeau gedaan aan een vriendin en ze was er dol op!',
            ]);
        }
    }
}
