<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            NewsSeeder::class,
            FaqCategorySeeder::class,
            FaqQuestionSeeder::class,
            ProfileMessageSeeder::class,
            WishlistSeeder::class,
            ReviewSeeder::class,
            NotificationSeeder::class,
            CartItemSeeder::class,
        ]);

        echo "\nDatabase succesvol gevuld voor WON-Stationary!\n";
    }
}
