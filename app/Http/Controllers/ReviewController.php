<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Sla een nieuwe review op.
     */
    public function store(Request $request, Product $product)
    {
        //Validatie van de invoer
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        //Controleren of de gebruiker al een review heeft geplaatst voor dit product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'U heeft al een review geschreven voor dit product.');
        }

        //Review aanmaken in de database
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Bedankt! Uw review is geplaatst.');
    }

    /**
     * Verwijder een review (voor admins of de eigenaar zelf).
     */
    public function destroy(Review $review)
    {
        // Beveiliging: Alleen de schrijver of een admin mag verwijderen
        if (Auth::id() !== $review->user_id && !Auth::user()->is_admin) {
            abort(403, 'Onbevoegde actie.');
        }

        $review->delete();

        return back()->with('success', 'De review is verwijderd.');
    }
}
