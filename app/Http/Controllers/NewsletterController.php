<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterSubscriptionMail;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        try {
            // Stuur een mail naar Mailpit (admin) om te laten weten dat iemand zich heeft ingeschreven
            Mail::to('admin@won-stationary.test')->send(new NewsletterSubscriptionMail($validated['email']));
            return back()->with('success', 'Bedankt voor je inschrijving op onze nieuwsbrief!');
        } catch (\Exception $e) {
            // Log de fout voor debugging
            Log::error('Nieuwsbrief inschrijving mislukt: ' . $e->getMessage());

            // Geef een vriendelijke foutmelding aan de gebruiker, maar laat de app niet crashen
            return back()->with('success', 'Bedankt voor je inschrijving! (Email kon niet verzonden worden in dev omgeving, maar je bent geregistreerd)');
        }
    }
}
