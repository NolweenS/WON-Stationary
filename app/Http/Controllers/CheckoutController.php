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
        $cart = session()->get('cart', []);

        if(count($cart) < 1) {
            return redirect()->route('products.index')->with('error', 'Winkelwagen is leeg.');
        }

        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cart', 'total'));
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

        $cart = session()->get('cart', []);

        if(count($cart) < 1) {
            return redirect()->route('products.index');
        }

        // Totaal berekenen
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

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
            foreach($cart as $id => $item) {
                $product = Product::find($id);

                if (!$product || $product->stock < $item['quantity']) {
                    throw new \Exception("Product '{$item['name']}' is niet meer voldoende op voorraad.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Voorraad verminderen
                $product->decrement('stock', $item['quantity']);
            }

            DB::commit();

            // Winkelwagen legen
            session()->forget('cart');


            return redirect()->route('orders.index')->with('success', 'Bedankt! Je bestelling ' . $order->order_number . ' is geplaatst.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Er ging iets mis: ' . $e->getMessage())->withInput();
        }
    }
}
