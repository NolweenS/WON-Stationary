<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\News;
use App\Models\FAQQuestion;
use App\Models\FaqCategory;
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
        $users = User::factory(10)->create();

        //5 Categorieën aanmaken
        $categories = Category::factory(5)->create();

        //50 producten aan maken
        $products = Product::factory(50)
            //We gaan de producten direct aan de categorieën van boven koppelen
            ->recycle($categories)
            ->create();

        // Reveiws aanmaken
        // We gaan geen willikeurige users gebruiken
        $users ->each(function ($user) use ($products)
        {
            //We laten een klant 1 tot3 willekeurige producten reviewen
            $products->random(rand(1,3))->each(function ($product) use ($user)
            {
                review::factory()->create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                ]);
            });
        });

        //Nieuws aanmaken
        news::factory(5)->create();

        //FAQ sectie aanmaken
        $faqCategories = FaqCategory::factory()
            ->count(4)
            ->sequence(
                ['name' => 'Ordering', 'slug' => 'ordering'],
        ['name' => 'Payment', 'slug' => 'Payment'],
        ['name' => 'Shipping', 'slug' => 'Shipping'],
        ['name' => 'Returns', 'slug' => 'Returns']
            )
            ->create();

        FaqQuestion::factory(10)
            ->recycle($categories)
            ->create();


        echo "Database succesvol gevuld met: \n";
        echo "- 1 Admin (admin@ehb.be)\n";
        echo "- 10 Klanten\n";
        echo "- 5 Categorieën\n";
        echo "- 50 Producten\n";
        echo "- 50 Reviews\n";
    }
}
