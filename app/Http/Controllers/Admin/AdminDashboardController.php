<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;

class AdminDashboardController extends Controller
{
    public function index()
    {
        //Totaal aantal gebruikers
        $totalUsers = User::count();

        // Totale omzet (alleen van voltooide bestellingen)
        $revenue = Order::where('status', 'completed')->sum('total_price');

        //Aantal bestellingen die nog verwerkt moeten worden
        $openOrders = Order::where('status', 'pending')
            ->orWhere('status', 'paid')
            ->count();

        // De 5 nieuwste bestellingen van IEDEREEN (met de user erbij)
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.admindashboard', [
            'totalUsers' => $totalUsers,
            'revenue' => $revenue,
            'openOrders' => $openOrders,
            'recentOrders' => $recentOrders,
        ]);
    }
}
