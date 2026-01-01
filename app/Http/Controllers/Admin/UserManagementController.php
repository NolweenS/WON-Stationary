<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserManagementController extends Controller
{
    // Display lijst van alle users
    public function index()
    {
        //Hall de users op
        $users = User::orderBy('created_at', 'desc')->paginate(20);

        //statistieken voor het dashboard
        $stats = [
            'total_users' => User::count(),
            'admin_count' => User::where('is_admin', true)->count(),
            'regular_users' => User::where('is_admin', false)->count(),
            'recent_users' => User::where('created_at', '>=', now()->subDays(30))->count(),
        ];
        return view('admin.users.index', compact('users', 'stats'));
    }

    // weergave voor het aanlaken van een form
    public function create()
    {
        return view('admin.users.create');
    }

    //oplaan van nieuwe gebruikers
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->has('is_admin'),
        ]);

        return redirect()->route('admin.users.index')->with('success', "User '{$user->name}' aangemaakt!");
    }

    //Een user een admin maken
    public function promote(User $user)
    {
        $user->update(['is_admin' => true]);
        return back()->with('success', "{$user->name} is nu Admin.");
    }

    //een admin deomte
    public function demote(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Je kunt jezelf niet degraderen!');
        }
        $user->update(['is_admin' => false]);
        return back()->with('success', "{$user->name} is geen Admin meer.");
    }

    //Verwijder een user
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Je kunt jezelf niet verwijderen!');
        }
        $user->delete();
        return back()->with('success', 'Gebruiker verwijderd.');
    }
}
