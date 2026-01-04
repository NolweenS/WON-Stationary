<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Toon de winkelwagen
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    // Product toevoegen aan winkelwagen
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        // Validatie: check voorraad
        if($product->stock <= 0) {
            return redirect()->back()->with('error', 'Dit product is niet meer op voorraad.');
        }

        // Als product al in cart zit, aantal verhogen
        if(isset($cart[$id])) {
            // Check of er nog genoeg voorraad is voor de extra toevoeging
            if($cart[$id]['quantity'] + 1 > $product->stock) {
                return redirect()->back()->with('error', 'Niet genoeg voorraad beschikbaar.');
            }
            $cart[$id]['quantity']++;
        } else {
            // Nieuw product toevoegen
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image,
                "stock" => $product->stock
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product toegevoegd aan winkelwagen!');
    }

    // Aantal aanpassen
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            $quantity = $request->input('quantity');

            // Simpele voorraad check op basis van sessie data
            if($quantity > $cart[$id]['stock']) {
                session()->flash('error', 'Niet genoeg voorraad beschikbaar.');
            } else if ($quantity > 0) {
                $cart[$id]['quantity'] = $quantity;
                session()->put('cart', $cart);
                session()->flash('success', 'Winkelwagen bijgewerkt.');
            } else {
                // Als aantal 0 of minder is, verwijder item
                unset($cart[$id]);
                session()->put('cart', $cart);
            }
        }

        return redirect()->back();
    }

    // Item verwijderen
    public function remove($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product verwijderd uit winkelwagen.');
    }
}
