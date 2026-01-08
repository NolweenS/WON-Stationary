<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // We halen de admin op die we in de AdminUserSeeder hebben gemaakt
        $admin = User::where('email', 'admin@ehb.be')->first();

        $newsItems = [
            [
                'title' => 'Nieuwe Collectie: Nude Planners',
                'content' => 'Onze langverwachte collectie minimalistische planners is eindelijk binnen. Ontdek de zachte tinten en hoogwaardige papierkwaliteit.',
                'image' => 'images/placeholder/planner1.jpg',
            ],
            [
                'title' => 'Tips voor een georganiseerd bureau',
                'content' => 'Een opgeruimd bureau zorgt voor een opgeruimde geest. Gebruik onze nieuwe accessoires om je werkplek te optimaliseren.',
                'image' => 'images/placeholder/acc1.jpg',
            ],
            [
                'title' => 'Waarom schrijven met de hand beter is',
                'content' => 'Wist je dat je informatie beter onthoudt als je het opschrijft? Onze nieuwe notebooks helpen je hierbij.',
                'image' => 'images/placeholder/notebook1.jpg',
            ],
            [
                'title' => 'Stationary trends voor 2026',
                'content' => 'Dit jaar draait alles om duurzaamheid en natuurlijke materialen. Lees er alles over in onze nieuwste blog.',
                'image' => 'images/placeholder/pens1.jpg',
            ],
            [
                'title' => 'Exclusieve korting op stickers',
                'content' => 'Deze week ontvang je 20% korting op al onze stickersets bij aankoop van een notebook.',
                'image' => 'images/placeholder/stickers1.jpg',
            ],
        ];

        foreach ($newsItems as $item) {
            News::create([
                'author_id' => $admin ? $admin->id : null,
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'content' => $item['content'],
                'image' => $item['image'],
                'published_at' => now(),
            ]);
        }
    }
}
