<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProfileMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileMessageController extends Controller
{
    public function store(Request $request, User $user)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        if (Auth::id() === $user->id) {
            return back()->with('error', 'Je kunt geen bericht naar jezelf sturen.');
        }

        ProfileMessage::create([
            'from_user_id' => Auth::id(),
            'to_user_id' => $user->id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return back()->with('success', 'Bericht geplaatst op profiel.');
    }

    public function destroy(ProfileMessage $message)
    {
        if (Auth::id() !== $message->from_user_id && !Auth::user()->is_admin) {
            abort(403, "The message can not be deleted.");
        }

        $message->delete();

        return back()->with('success', 'Bericht verwijderd.');
    }
}
