<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@ehb.be')->first();
        $emma = User::where('email', 'emma@example.com')->first();

        if ($admin) {
            Notification::create([
                'id' => Str::uuid(),
                'type' => 'App\Notifications\NewMessage',
                'notifiable_type' => User::class,
                'notifiable_id' => $admin->id,
                'data' => json_encode([
                    'title' => 'Nieuw bericht in gastenboek',
                    'message' => 'Liam heeft een bericht achtergelaten op het profiel van Emma.'
                ]),
                'read_at' => null,
            ]);
        }

        if ($emma) {
            Notification::create([
                'id' => Str::uuid(),
                'type' => 'App\Notifications\WelcomeNotification',
                'notifiable_type' => User::class,
                'notifiable_id' => $emma->id,
                'data' => json_encode([
                    'title' => 'Welkom bij WON-Stationary!',
                    'message' => 'Bedankt voor het aanmaken van je profiel.'
                ]),
                'read_at' => now(),
            ]);
        }
    }
}
