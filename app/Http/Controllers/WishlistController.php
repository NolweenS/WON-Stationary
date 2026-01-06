<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    //Tonen van user wishlist
    public function index()
    {
        $user = auth()->user();

        $user->load(['wishlist.category']);

        $wishlistItems = $user->wishlist;

        $totalPrice = $wishlistItems->sum('price');

        return view('wishlist.index', compact('wishlistItems', 'totalPrice'));
    }

    //Product in de wishlist toevoegen
    public function store(Product $product)
    {
        $user = auth()->user();

        if ($user->hasInWishlist($product)) {
            return back()->with('error', 'Dit product staat al op je verlanglijstje.');
        }

        $user->wishlist()->attach($product->id);

        return back()->with('success', "{$product->name} toegevoegd aan je verlanglijstje!");
    }

    public function destroy(Product $product)
    {
        $user = auth()->user();

        if (!$user->hasInWishlist($product)) {
            return back()->with('error', 'Dit product staat niet op je verlanglijstje.');
        }

        $user->wishlist()->detach($product->id);

        return back()->with('success', "{$product->name} verwijderd van je verlanglijstje.");
    }

    public function toggle(Product $product)
    {
        $user = auth()->user();

        // Toggle de status
        $changes = $user->wishlist()->toggle($product->id);

        // Bepaal of het toegevoegd (attached) of verwijderd (detached) is
        $isAdded = !empty($changes['attached']);

        // Als het verzoek via AJAX (JavaScript) komt, stuur JSON terug
        if (request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'in_wishlist' => $isAdded,
                'message' => $isAdded ? "{$product->name} toegevoegd aan verlanglijstje" : "{$product->name} verwijderd van verlanglijstje"
            ]);
        }

        // Fallback voor als Javascript uit staat
        if ($isAdded) {
            return back()->with('success', "{$product->name} toegevoegd aan je verlanglijstje!");
        } else {
            return back()->with('success', "{$product->name} verwijderd van je verlanglijstje.");
        }
    }
}
