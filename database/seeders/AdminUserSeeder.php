<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * We gaan één admin gebruiker aanmaken met een bijbehorend profiel.
     */
    public function run(): void
    {
        // We gaan een user (admin) aanmaken
        $admin = User::create([
            'name' => 'Admin WON',
            'email' => 'admin@ehb.be',
            'password' => Hash::make('Password!321'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Profiel aanmaken
        Profile::create([
            'user_id' => $admin->id,
            'username' => 'Administrator',
            'birthday' => '1990-01-01',
            'about_me' => 'Hoofdbeheerder van WON-Stationary.',
            // UI-Avatar link
            'profile_photo' => 'https://ui-avatars.com/api/?background=f5ebe0&color=d5bdaf&name=Admin+WON',
        ]);
    }
}
