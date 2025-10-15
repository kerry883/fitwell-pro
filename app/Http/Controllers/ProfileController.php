<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display user profile.
     */
    public function index()
    {
        return view('profile.index');
    }
}