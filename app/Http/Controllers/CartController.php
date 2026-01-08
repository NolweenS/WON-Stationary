<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    /**
     * Toon de winkelwagen.
     */
    public function index()
    {

        $cartItems = CartItem::getCurrentCart();
        $total = CartItem::cartTotal();

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Product toevoegen aan winkelwagen.
     */
    public function add(int $id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        $userId = auth()->id();
        $sessionId = Session::getId();

        // Zoek of het item al bestaat voor deze bezoeker
        $cartItem = CartItem::where('product_id', $id)
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->first();

        if ($cartItem) {
            // Check voorraad
            if ($cartItem->quantity + 1 > $product->stock) {
                return redirect()->back()->with('error', 'Niet genoeg voorraad.');
            }
            $cartItem->increment('quantity');
        } else {
            // Maak nieuw item aan in de database
            CartItem::create([
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'product_id' => $id,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Toegevoegd aan je mandje!');
    }

    /**
     * Aantal aanpassen in de winkelwagen.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $cartItem = CartItem::findOrFail($id);
        $newQuantity = (int) $request->input('quantity');

        // Voorraad check
        if ($newQuantity > $cartItem->product->stock) {
            return redirect()->back()->with('error', 'Niet genoeg voorraad.');
        }

        if ($newQuantity <= 0) {
            $cartItem->delete();
        } else {
            $cartItem->update(['quantity' => $newQuantity]);
        }

        return redirect()->back()->with('success', 'Winkelwagen bijgewerkt.');
    }

    /**
     * Item volledig verwijderen.
     */
    public function remove(int $id): RedirectResponse
    {
        CartItem::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Item verwijderd.');
    }
}
