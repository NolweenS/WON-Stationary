<?php

namespace Database\Seeders;

use App\Models\FaqQuestion;
use App\Models\FaqCategory;
use Illuminate\Database\Seeder;

class FaqQuestionSeeder extends Seeder
{
    public function run(): void
    {
        // We halen de categorieën
        $bestelling = FaqCategory::where('name', 'Bestellingen')->first();
        $verzending = FaqCategory::where('name', 'Verzending')->first();

        // Vragen voor Bestellingen
        FaqQuestion::create([
            'faq_category_id' => $bestelling->id,
            'question' => 'Kan ik mijn bestelling nog wijzigen?',
            'answer' => 'Zodra een bestelling is geplaatst, gaan we direct aan de slag. Neem zo snel mogelijk contact op met onze klantenservice.'
        ]);

        FaqQuestion::create([
            'faq_category_id' => $bestelling->id,
            'question' => 'Ontvang ik een orderbevestiging?',
            'answer' => 'Ja, direct na je betaling ontvang je een bevestiging in je mailbox.'
        ]);

        // Vragen voor Verzending
        FaqQuestion::create([
            'faq_category_id' => $verzending->id,
            'question' => 'Wat is de levertijd?',
            'answer' => 'Voor 16:00 besteld is de volgende werkdag in huis.'
        ]);

        FaqQuestion::create([
            'faq_category_id' => $verzending->id,
            'question' => 'Verzenden jullie ook naar het buitenland?',
            'answer' => 'Momenteel verzenden wij enkel binnen België en Nederland.'
        ]);
    }
}
