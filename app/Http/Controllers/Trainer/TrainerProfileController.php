<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerProfileController extends Controller
{
    /**
     * Display trainer profile
     */
    public function index()
    {
        $trainer = Auth::user();
        $trainerProfile = $trainer->trainerProfile;
        
        return view('trainer.profile.index', compact('trainer', 'trainerProfile'));
    }
    
    /**
     * Show profile edit form
     */
    public function edit()
    {
        $trainer = Auth::user();
        $trainerProfile = $trainer->trainerProfile;
        
        return view('trainer.profile.edit', compact('trainer', 'trainerProfile'));
    }
    
    /**
     * Update trainer profile
     */
    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'bio' => 'nullable|string|max:1000',
            'certifications' => 'nullable|array',
            'specializations' => 'nullable|array',
            'years_experience' => 'nullable|integer|min:0|max:50',
            'education' => 'nullable|string|max:500',
            'approach_description' => 'nullable|string|max:1000',
            'business_name' => 'nullable|string|max:255',
            'business_address' => 'nullable|string|max:255',
            'business_phone' => 'nullable|string|max:20',
            'business_email' => 'nullable|email|max:255',
            'website_url' => 'nullable|url|max:255',
            'hourly_rate' => 'nullable|numeric|min:0',
            'max_clients' => 'nullable|integer|min:1|max:100',
            'accepting_new_clients' => 'boolean',
            'training_locations' => 'nullable|array',
            'cancellation_policy' => 'nullable|string|max:1000',
        ]);
        
        $trainer = Auth::user();
        
        // Update user basic info
        $trainer->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);
        
        // Update trainer profile
        $trainerProfile = $trainer->trainerProfile;
        if ($trainerProfile) {
            $trainerProfile->update($request->except(['first_name', 'last_name', 'email', '_token', '_method']));
        }
        
        return redirect()->route('trainer.profile.index')
            ->with('success', 'Profile updated successfully!');
    }
    
    /**
     * Update trainer availability
     */
    public function updateAvailability(Request $request)
    {
        $request->validate([
            'availability_schedule' => 'required|array',
        ]);
        
        $trainer = Auth::user();
        $trainerProfile = $trainer->trainerProfile;
        
        if ($trainerProfile) {
            $trainerProfile->update([
                'availability_schedule' => $request->availability_schedule
            ]);
        }
        
        return redirect()->route('trainer.profile.index')
            ->with('success', 'Availability updated successfully!');
    }
    
    /**
     * Update trainer rates
     */
    public function updateRates(Request $request)
    {
        $request->validate([
            'hourly_rate' => 'required|numeric|min:0',
            'package_rates' => 'nullable|array',
        ]);
        
        $trainer = Auth::user();
        $trainerProfile = $trainer->trainerProfile;
        
        if ($trainerProfile) {
            $trainerProfile->update([
                'hourly_rate' => $request->hourly_rate,
                'package_rates' => $request->package_rates
            ]);
        }
        
        return redirect()->route('trainer.profile.index')
            ->with('success', 'Rates updated successfully!');
    }
}