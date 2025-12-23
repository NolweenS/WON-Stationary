<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * We gaan de werking van de database vaststellen door Seed
     */
    public function run(): void
    {
        user::factory()->create([
            'name' => 'admin Use',
            'email'=> 'admin@ehb.be',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        //Het aanmaken van 10 willekeurige klanten
        $user = User::factory(10)->create();

        //5 Categorieën aanmaken
        $categories = Category::factory(5)->create();

        //50 producten aan maken
        $products = Product::factory(50)
            //We gaan de producten direct aan de categorieën van boven koppelen
            ->recycle($categories)
            ->create();

        echo "Database succesvol gevuld met: \n";
        echo "- 1 Admin (admin@ehb.be)\n";
        echo "- 10 Klanten\n";
        echo "- 5 Categorieën\n";
        echo "- 50 Producten\n";
        echo "- 100 Reviews\n";
    }
}
