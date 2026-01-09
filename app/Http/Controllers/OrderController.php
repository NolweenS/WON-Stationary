<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Toon lijst met bestellingen van de ingelogde gebruiker.
     */
    public function index()
    {
        // Als de gebruiker admin is, toon ALLE bestellingen
        if (Auth::user()->isAdmin()) {
            $orders = Order::latest()->paginate(10);
        } else {
            // Anders alleen de eigen bestellingen
            $orders = Order::where('user_id', Auth::id())
                ->latest()
                ->paginate(10);
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Toon details van één specifieke bestelling.
     */
    public function show(Order $order)
    {
        // Beveiliging: Check of de bestelling wel van deze gebruiker is
        // We laten admins er wel bij (via is_admin check)
        if ($order->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403, 'U heeft geen toegang tot deze bestelling.');
        }

        // Laad de items en producten in één keer in voor betere performance
        $order->load(['items.product' => function($query) {
            $query->withTrashed(); // Zodat we ook verwijderde producten nog zien in de historie
        }]);

        return view('orders.show', compact('order'));
    }

    //Annuleer een bestelling
    public function cancel(Order $order)
    {
        //Beveiliging: Is het jouw order?
        if ($order->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }

        //Check of annuleren mag (Status is pending)
        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Deze bestelling kan niet meer geannuleerd worden omdat deze al in behandeling is.');
        }

        // Voer de annulering uit
        $order->cancel();

        return back()->with('success', 'De bestelling is succesvol geannuleerd.');
    }

    // Update de status van een bestelling (alleen voor admins)
    public function updateStatus(Request $request, Order $order)
    {
        // Extra beveiliging (hoewel middleware dit ook al doet)
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Alleen beheerders kunnen de status wijzigen.');
        }

        $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'De status van de bestelling is bijgewerkt naar ' . ucfirst($request->status) . '.');
    }
}
