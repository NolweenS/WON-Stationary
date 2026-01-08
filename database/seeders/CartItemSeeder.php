<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    public function run(): void
    {
        // We halen Emma op
        $emma = User::where('email', 'emma@example.com')->first();

        // We halen twee verschillende producten op om in het mandje te leggen
        $planner = Product::where('name', 'LIKE', '%Planner%')->first();
        $pen = Product::where('name', 'LIKE', '%Pens%')->first();

        if ($emma) {
            if ($planner) {
                CartItem::create([
                    'user_id' => $emma->id,
                    'product_id' => $planner->id,
                    'quantity' => 1,
                ]);
            }

            if ($pen) {
                CartItem::create([
                    'user_id' => $emma->id,
                    'product_id' => $pen->id,
                    'quantity' => 3,
                ]);
            }
        }
    }
}
