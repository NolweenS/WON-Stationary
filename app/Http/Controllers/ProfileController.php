<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


/**
 * Weergeeft de profiel en editing is mogelijk
 */
class ProfileController extends Controller
{
    //Een publieke zichtbare profiel van de user weergeven
    public function show(User $user)
    {
        $user->load([
            'profile',
            'reviews.product',
            'wishlist',
            'favorites',
        ]);
        return view('profile.show', compact('user'));
    }

    //eigen profiel edit alleen voor de ingelogde users
    public function edit()
    {
        $user = auth()->user();
        $user->load('profile');
        return view('profile.edit', compact('user'));
    }

    //Update profiel gegevens
    public function update(Request $request)
    {
        $user = auth()->user();
        //Validatie weergeven
        $validated = $request->validate([
            'username'=> 'nullable|string|max:255',
            'birthday'=> 'nullable|date|before:today',
            'about_me'=> 'nullable|string|max:1000',
            'profile_photo' =>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],[
            'birthday.before' => 'The birthday must be before today',
            'profile_photo.image' => 'File needs to be an image',
            'profile_photo.max'=> 'Image size is too large',
        ]);

        //Profiel ophalen of aanmaken
        $profile = $user->profile() ?? Profile::create(['user_id'=>$user->id]);

        //uploadenvan afbeelding
        if ($request->hasFile('profile_photo')) {
            if($profile->profile_photo){
                Storage::disk('public')->delete($profile->profile_photo);
            }
            //Upload een nieuwe afbeelding
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $validated['profile_photo'] = $path;
        }
        //Profiel updaten
        $profile->update($validated);

        return redirect()
            ->route('profile.show', $user)
            ->with('success', 'Profile updated successfully');
    }

    //Profielfoto verwijderen
    public function deletePhoto()
    {
        $user = auth()->user();
        $profile = $user->profile();

        if($profile && $profile->profile_photo)
        {
            //Verwijder afbeelding van disk
            Storage::disk('public')->delete($profile->profile_photo);

            //Update database
            $profile->update(['profile_photo' => null]);

            return back()->with('success', 'Profile photo deleted successfully');
        }

        return back()->with('error', 'Profile photo not found');
    }
}
