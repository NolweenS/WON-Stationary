<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class SocialSeeder extends Seeder
{
    public function run(): void
    {
        //we alen de user op
        $emma = User::where('email', 'emma@example.com')->first();
        $producten = Product::limit(5)->get();

        if ($emma && $producten->count() >= 2) {
            // Emma zet de eerste 2 producten op haar verlanglijst
            $emma->wishlist()->attach([$producten[0]->id, $producten[1]->id]);

            // Emma markeert het derde product als favoriet
            $emma->favorites()->attach($producten[2]->id);
        }
    }
}
