@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">My Profile</h1>

            @if(Auth::user()->isClient())
                @include('profile.client-profile')
            @elseif(Auth::user()->isTrainer())
                @include('trainer.profile.index')
            @endif
        </div>
    </div>
</div>
@endsection
