<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Toon checkout pagina
    public function index()
    {
        $cartItems = \App\Models\CartItem::getCurrentCart() ?? collect([]);

        if($cartItems->count() < 1) {
            return redirect()->route('products.index')->with('error', 'Winkelwagen is leeg.');
        }

        $total = \App\Models\CartItem::cartTotal() ?? 0;

        return view('checkout.index', compact('cartItems', 'total'));
    }

    // Verwerk de bestelling
    public function store(Request $request)
    {
        //Validatie
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_postal' => 'required|string|max:20',
        ]);

        $cartItems = \App\Models\CartItem::getCurrentCart() ?? collect([]);

        if($cartItems->count() < 1) {
            return redirect()->route('products.index');
        }

        // Totaal berekenen
        $total = \App\Models\CartItem::cartTotal() ?? 0;

        try {
            DB::beginTransaction();

            //Order aanmaken
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'total_price' => $total,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_postal' => $request->shipping_postal,
            ]);

            //Order Items aanmaken
            foreach($cartItems as $cartItem) {
                $product = $cartItem->product;

                if (!$product || $product->stock < $cartItem->quantity) {
                    throw new \Exception("Product '{$product->name}' is niet meer voldoende op voorraad.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $product->price,
                ]);

                // Voorraad verminderen
                $product->decrement('stock', $cartItem->quantity);
            }

            DB::commit();

            // Winkelwagen legen (verwijder alle cart items voor deze gebruiker/sessie)
            \App\Models\CartItem::clearCart();

            return redirect()->route('orders.index')->with('success', 'Bedankt! Je bestelling ' . $order->order_number . ' is geplaatst.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Er ging iets mis: ' . $e->getMessage())->withInput();
        }
    }
}
