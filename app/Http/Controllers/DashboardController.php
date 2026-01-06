<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Toon het dashboard voor de ingelogde gebruiker.
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        //Recente bestellingen
        $recentOrders = $user->orders()
            ->latest() // Nieuwste eerst
            ->take(5)  // Maximaal 5
            ->get();

        // Aantal lopende bestellingen
        $activeOrdersCount = $user->orders()
            ->whereNotIn('status', ['completed', 'cancelled', 'geannuleerd'])
            ->count();

        // 3. Wishlist items tellen
        $wishlistCount = $user->wishlist()->count();

        // Aantal reviews geschreven
        $reviewsCount = $user->reviews()->count();

        return view('dashboard', [
            'user' => $user,
            'recentOrders' => $recentOrders,
            'wishlistCount' => $wishlistCount,
            'activeOrdersCount' => $activeOrdersCount,
            'reviewsCount' => $reviewsCount
        ]);
    }
}
