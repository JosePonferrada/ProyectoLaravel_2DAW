<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        // Handle profile photo upload
        if ($request->hasFile('avatar')) {
            // Delete old profile photo if exists
            if ($request->user()->profile_photo) {
                Storage::disk('public')->delete($request->user()->profile_photo);
            }
            
            // Store the new profile photo
            $path = $request->file('avatar')->store('profile-photos', 'public');
            $request->user()->profile_photo = $path;
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // If user has a profile photo, delete it
        if ($request->user()->profile_photo) {
            Storage::disk('public')->delete($request->user()->profile_photo);
        }
        
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Delete the user's profile photo.
     */
    public function deletePhoto(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        // Delete profile photo from storage
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            
            // Remove the profile photo path from the user record
            $user->profile_photo = null;
            $user->save();
        }
        
        return Redirect::route('profile.edit')->with('status', 'profile-photo-deleted');
    }
}
