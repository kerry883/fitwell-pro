@extends('layouts.trainer')

@section('title', 'Edit Profile')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('trainer.profile.index') }}">Profile</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
            <h1 class="h3 mb-0">Edit Profile</h1>
            <p class="text-muted">Update your professional information and settings</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('trainer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Profile Photo -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xl me-3">
                                        @if($trainer->profile_picture)
                                            <img src="{{ Storage::url($trainer->profile_picture) }}"
                                                 alt="Profile Photo" class="rounded-circle" width="80" height="80"
                                                 style="object-fit: cover;">
                                        @else
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                                 style="width: 80px; height: 80px; font-size: 2rem;">
                                                {{ substr($trainer->first_name, 0, 1) }}{{ substr($trainer->last_name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Profile Photo</h6>
                                        <input type="file" class="form-control form-control-sm" name="profile_photo" accept="image/*">
                                        <small class="text-muted">JPG, PNG or GIF. Max size 2MB.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="first_name" name="first_name"
                                       value="{{ $trainer->first_name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                       value="{{ $trainer->last_name }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ $trainer->email }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Professional Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4"
                                      placeholder="Tell your clients about yourself, your approach, and what makes you unique">{{ $trainerProfile->bio ?? '' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="education" class="form-label">Education</label>
                            <input type="text" class="form-control" id="education" name="education"
                                   value="{{ $trainerProfile->education ?? '' }}"
                                   placeholder="e.g., B.S. Exercise Science, ACE Certified">
                        </div>

                        <div class="mb-3">
                            <label for="years_experience" class="form-label">Years of Experience</label>
                            <input type="number" class="form-control" id="years_experience" name="years_experience"
                                   value="{{ $trainerProfile->years_experience ?? '' }}" min="0" max="50">
                        </div>

                        <div class="mb-3">
                            <label for="approach_description" class="form-label">Training Approach</label>
                            <textarea class="form-control" id="approach_description" name="approach_description" rows="3"
                                      placeholder="Describe your training philosophy and approach">{{ $trainerProfile->approach_description ?? '' }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('trainer.profile.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Business Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Business Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('trainer.profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="business_name" class="form-label">Business Name</label>
                            <input type="text" class="form-control" id="business_name" name="business_name"
                                   value="{{ $trainerProfile->business_name ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="business_email" class="form-label">Business Email</label>
                            <input type="email" class="form-control" id="business_email" name="business_email"
                                   value="{{ $trainerProfile->business_email ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="business_phone" class="form-label">Business Phone</label>
                            <input type="tel" class="form-control" id="business_phone" name="business_phone"
                                   value="{{ $trainerProfile->business_phone ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="website_url" class="form-label">Website</label>
                            <input type="url" class="form-control" id="website_url" name="website_url"
                                   value="{{ $trainerProfile->website_url ?? '' }}"
                                   placeholder="https://example.com">
                        </div>

                        <div class="mb-3">
                            <label for="business_address" class="form-label">Business Address</label>
                            <textarea class="form-control" id="business_address" name="business_address" rows="2">{{ $trainerProfile->business_address ?? '' }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Update Business Info</button>
                    </form>
                </div>
            </div>

            <!-- Client Settings -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Client Settings</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('trainer.profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label for="hourly_rate" class="form-label">Hourly Rate ($)</label>
                            <input type="number" class="form-control" id="hourly_rate" name="hourly_rate"
                                   value="{{ $trainerProfile->hourly_rate ?? '' }}" min="0" step="0.01">
                        </div>

                        <div class="mb-3">
                            <label for="max_clients" class="form-label">Maximum Clients</label>
                            <input type="number" class="form-control" id="max_clients" name="max_clients"
                                   value="{{ $trainerProfile->max_clients ?? 20 }}" min="1" max="100">
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="accepting_new_clients" 
                                       name="accepting_new_clients" value="1" {{ $trainerProfile->accepting_new_clients ? 'checked' : '' }}>
                                <label class="form-check-label" for="accepting_new_clients">
                                    Accepting New Clients
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="cancellation_policy" class="form-label">Cancellation Policy</label>
                            <textarea class="form-control" id="cancellation_policy" name="cancellation_policy" rows="3">{{ $trainerProfile->cancellation_policy ?? '' }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Update Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
