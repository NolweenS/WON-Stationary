<?php

namespace Database\Seeders;

use App\Models\ProfileMessage;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfileMessageSeeder extends Seeder
{
    public function run(): void
    {
        // Haal de gebruikers op
        $emma = User::where('email', 'emma@example.com')->first();
        $liam = User::where('email', 'liam@example.com')->first();

        if ($emma && $liam) {
            //Liam plaatst een bericht op het profiel van Emma
            $mainMessage = ProfileMessage::create([
                // De ontvanger
                'to_user_id'   => $emma->id,
                // De afzender
                'from_user_id' => $liam->id,
                'message'      => 'Hey Emma! Wat een leuke profielfoto. Die nieuwe planners zien er echt top uit.',
                'parent_id'    => null,
            ]);

            //Emma reageert op haar eigen profiel
            ProfileMessage::create([
                'to_user_id'   => $emma->id,  // Het blijft op Emma's profiel
                'from_user_id' => $emma->id,
                'message'      => 'Dankjewel Liam! Ik ben er zelf ook heel blij mee.',
                'parent_id'    => $mainMessage->id,
            ]);
        }
    }
}
