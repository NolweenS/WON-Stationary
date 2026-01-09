<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // lijst met gebruikers
        $users = [
            [
                'name' => 'Emma de Vries',
                'email' => 'emma@example.com',
                'username' => 'EmmaStationary',
                'birthday' => '1995-05-15',
                'about_me' => 'Gek op planners en minimalistische bureau-accessoires.'
            ],
            [
                'name' => 'Liam Jansen',
                'email' => 'liam@example.com',
                'username' => 'LiamWrites',
                'birthday' => '1992-10-20',
                'about_me' => 'Altijd op zoek naar het perfecte notitieboek.'
            ],
            [
                'name' => 'Sophie Bakker',
                'email' => 'sophie@example.com',
                'username' => 'SophieB',
                'birthday' => '1998-03-12',
                'about_me' => 'Creativiteit op papier is mijn passie.'
            ],
            [
                'name' => 'Noah van Dijk',
                'email' => 'noah@example.com',
                'username' => 'NoahDijk',
                'birthday' => '1994-07-25',
                'about_me' => 'Organisatie is de sleutel tot succes.'
            ],
        ];

        foreach ($users as $data) {
            //Maak de User aan in de users tabel
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'is_admin' => false,
                'email_verified_at' => now(),
                'phone' => '0470123456',
            ]);

            // Maak direct het bijbehorende profiel aan
            Profile::create([
                'user_id' => $user->id,
                'username' => $data['username'],
                'birthday' => $data['birthday'],
                'about_me' => $data['about_me'],
                'profile_photo' => null,
            ]);
        }
    }
}
