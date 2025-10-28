<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilePhotoController extends Controller
{
    /**
     * Update trainer profile photo
     */
    public function update(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $trainer = Auth::user();

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $image = $request->file('profile_photo');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('profile_photos', $filename, 'public');

            // Delete old profile photo if exists
            if ($trainer->profile_picture) {
                Storage::disk('public')->delete($trainer->profile_picture);
            }

            $trainer->profile_picture = $path;
            $trainer->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile photo updated successfully!',
            'photo_url' => $trainer->profile_picture ? Storage::url($trainer->profile_picture) : null
        ]);
    }
}
