<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use App\Mail\ContactConfirmationMail;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    //Toont het formulier
    public function show()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Opslaan in database
        ContactMessage::create($validated);

        // Mail naar admin sturen
        Mail::to('admin@won-stationary.test')->send(new ContactFormMail($validated));

        // Bevestiging naar Klant
        Mail::to($validated['email'])->send(new ContactConfirmationMail($validated));

        return back()->with('success', 'Bedankt! Je bericht is verzonden en opgeslagen.');
    }
}
