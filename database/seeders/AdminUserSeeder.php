<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\HasH;

class AdminUserSeeder extends Seeder
{
    /*
     We gaan één gebruiker aanmaken
     */
    public function run(): void
    {
        user::create([
            'name' => 'Admin',
            'email' => 'admin@ehb.be',
            'password' => Hash::make('Password!321'),
        ]);
    }
}
