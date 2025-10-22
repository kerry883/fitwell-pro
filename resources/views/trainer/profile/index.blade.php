@extends('layouts.trainer')

@section('title', 'Trainer Profile')
@section('page-title', 'My Profile')
@section('page-subtitle', 'Manage your professional profile and settings')

@section('content')
<div class="row g-4">
    <!-- Profile Header -->
    <div class="col-12">
        <div class="card trainer-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        @if($trainer->profile_picture)
                            <img src="{{ Storage::url($trainer->profile_picture) }}" 
                                 alt="Profile" class="rounded-circle mb-2" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2" 
                                 style="width: 80px; height: 80px; font-size: 2rem;">
                                {{ substr($trainer->first_name, 0, 1) }}{{ substr($trainer->last_name, 0, 1) }}
                            </div>
                        @endif
                        <a href="{{ route('trainer.profile.edit') }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-camera"></i> Change Photo
                        </a>
                    </div>
                    <div class="col-md-7">
                        <h3 class="mb-1">{{ $trainer->full_name }}</h3>
                        <p class="text-muted mb-2">{{ $trainer->email }}</p>
                        @if($trainerProfile)
                            <div class="mb-2">
                                @if($trainerProfile->business_name)
                                    <span class="badge bg-primary me-2">{{ $trainerProfile->business_name }}</span>
                                @endif
                                @if($trainerProfile->years_experience)
                                    <span class="badge bg-success me-2">{{ $trainerProfile->years_experience }} years experience</span>
                                @endif
                                @if($trainerProfile->certifications)
                                    <span class="badge bg-info me-2">{{ count($trainerProfile->certifications) }} certifications</span>
                                @endif
                            </div>
                            @if($trainerProfile->bio)
                                <p class="text-muted mb-0">{{ Str::limit($trainerProfile->bio, 150) }}</p>
                            @endif
                        @endif
                    </div>
                    <div class="col-md-3 text-md-end">
                        <a href="{{ route('trainer.profile.edit') }}" class="btn trainer-btn-primary">
                            <i class="bi bi-pencil me-2"></i>Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="row g-4">
        <!-- Left Column -->
        <div class="col-md-4">
            <!-- Professional Info -->
            <div class="card trainer-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Professional Info</h5>
                </div>
                <div class="card-body">
                    @if($trainerProfile)
                        <div class="mb-3">
                            <label class="form-label text-muted small">Years of Experience</label>
                            <div class="fw-bold">{{ $trainerProfile->years_experience ?? 'Not specified' }} years</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Education</label>
                            <div class="fw-bold">{{ $trainerProfile->education ?? 'Not specified' }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Hourly Rate</label>
                            <div class="fw-bold text-success">${{ $trainerProfile->hourly_rate ?? 'Not set' }}/hour</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">Client Capacity</label>
                            <div class="fw-bold">{{ $trainerProfile->current_clients ?? 0 }} / {{ $trainerProfile->max_clients ?? 20 }} clients</div>
                            <div class="progress mt-1" style="height: 6px;">
                                <div class="progress-bar bg-success" 
                                     style="width: {{ ($trainerProfile->current_clients / $trainerProfile->max_clients) * 100 }}%"></div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label text-muted small">Accepting New Clients</label>
                            <div>
                                @if($trainerProfile->accepting_new_clients)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-danger">No</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <p class="text-muted">Complete your trainer profile to display professional information.</p>
                        <a href="{{ route('trainer.profile.edit') }}" class="btn btn-sm trainer-btn-primary">
                            Complete Profile
                        </a>
                    @endif
                </div>
            </div>

            <!-- Certifications -->
            <div class="card trainer-card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-award me-2"></i>Certifications</h5>
                </div>
                <div class="card-body">
                    @if($trainerProfile && $trainerProfile->certifications)
                        @foreach($trainerProfile->certifications as $cert)
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-patch-check text-success me-2"></i>
                                <span>{{ $cert }}</span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted mb-2">No certifications listed yet.</p>
                    @endif
                    <button class="btn btn-sm btn-outline-primary w-100 mt-2">
                        <i class="bi bi-plus me-1"></i>Add Certification
                    </button>
                </div>
            </div>

            <!-- Specializations -->
            <div class="card trainer-card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-star me-2"></i>Specializations</h5>
                </div>
                <div class="card-body">
                    @if($trainerProfile && !empty($trainerProfile->specializations))
                        @php $specializations = is_array($trainerProfile->specializations) ? $trainerProfile->specializations : []; @endphp
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($specializations as $spec)
                                <span class="badge bg-light text-dark">{{ $spec }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-2">No specializations listed yet.</p>
                    @endif
                    <button class="btn btn-sm btn-outline-primary w-100 mt-2">
                        <i class="bi bi-plus me-1"></i>Add Specialization
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-md-8">
            <!-- Profile Tabs -->
            <div class="card trainer-card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview-tab">
                                <i class="bi bi-person me-2"></i>Overview
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#business-tab">
                                <i class="bi bi-building me-2"></i>Business Info
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#availability-tab">
                                <i class="bi bi-calendar-week me-2"></i>Availability
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#settings-tab">
                                <i class="bi bi-gear me-2"></i>Settings
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview-tab">
                            @if($trainerProfile)
                                <div class="mb-4">
                                    <h6>About Me</h6>
                                    <p class="text-muted">
                                        {{ $trainerProfile->bio ?? 'No bio provided yet. Tell your potential clients about yourself!' }}
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <h6>Training Approach</h6>
                                    <p class="text-muted">
                                        {{ $trainerProfile->approach_description ?? 'No training approach described yet.' }}
                                    </p>
                                </div>

                                @if($trainerProfile->training_locations)
                                    <div class="mb-4">
                                        <h6>Training Locations</h6>
                                        <div class="row g-2">
                                            @foreach($trainerProfile->training_locations as $location)
                                                <div class="col-auto">
                                                    <span class="badge bg-light text-dark">{{ $location }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if($trainerProfile->social_media_links)
                                    <div class="mb-4">
                                        <h6>Social Media</h6>
                                        <div class="d-flex gap-2">
                                            @foreach($trainerProfile->social_media_links as $platform => $link)
                                                <a href="{{ $link }}" class="btn btn-outline-primary btn-sm" target="_blank">
                                                    <i class="bi bi-{{ strtolower($platform) }}"></i>
                                                    {{ ucfirst($platform) }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-person-plus text-muted" style="font-size: 3rem;"></i>
                                    <h5 class="mt-3 mb-2">Complete Your Profile</h5>
                                    <p class="text-muted mb-3">Let clients know more about you by completing your trainer profile.</p>
                                    <a href="{{ route('trainer.profile.edit') }}" class="btn trainer-btn-primary">
                                        <i class="bi bi-pencil me-2"></i>Complete Profile
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Business Info Tab -->
                        <div class="tab-pane fade" id="business-tab">
                            @if($trainerProfile)
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small">Business Name</label>
                                        <div class="fw-bold">{{ $trainerProfile->business_name ?? 'Not provided' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small">Business Email</label>
                                        <div class="fw-bold">{{ $trainerProfile->business_email ?? 'Not provided' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small">Business Phone</label>
                                        <div class="fw-bold">{{ $trainerProfile->business_phone ?? 'Not provided' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small">Website</label>
                                        <div class="fw-bold">
                                            @if($trainerProfile->website_url)
                                                <a href="{{ $trainerProfile->website_url }}" target="_blank">{{ $trainerProfile->website_url }}</a>
                                            @else
                                                Not provided
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label text-muted small">Business Address</label>
                                        <div class="fw-bold">{{ $trainerProfile->business_address ?? 'Not provided' }}</div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small">Cancellation Policy</label>
                                        <div class="small">{{ $trainerProfile->cancellation_policy ?? 'No cancellation policy set' }}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small">Package Rates</label>
                                        @if($trainerProfile->package_rates)
                                            <div class="small">
                                                @foreach($trainerProfile->package_rates as $package => $rate)
                                                    <div>{{ $package }}: ${{ $rate }}</div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="small">No package rates set</div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-building text-muted" style="font-size: 3rem;"></i>
                                    <h5 class="mt-3 mb-2">Set Up Your Business Info</h5>
                                    <p class="text-muted mb-3">Add your business details to appear more professional to clients.</p>
                                    <a href="{{ route('trainer.profile.edit') }}" class="btn trainer-btn-primary">
                                        <i class="bi bi-plus me-2"></i>Add Business Info
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Availability Tab -->
                        <div class="tab-pane fade" id="availability-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Weekly Schedule</h6>
                                <button class="btn btn-sm trainer-btn-primary">
                                    <i class="bi bi-pencil me-1"></i>Edit Schedule
                                </button>
                            </div>

                            <div class="row g-3">
                                @php
                                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                    $schedule = $trainerProfile->availability_schedule ?? [];
                                @endphp

                                @foreach($days as $day)
                                    <div class="col-12">
                                        <div class="d-flex align-items-center p-3 border rounded">
                                            <div class="me-3" style="width: 100px;">
                                                <strong>{{ $day }}</strong>
                                            </div>
                                            <div class="flex-grow-1">
                                                @if(isset($schedule[$day]) && $schedule[$day]['available'])
                                                    <span class="badge bg-success me-2">Available</span>
                                                    <small class="text-muted">
                                                        {{ $schedule[$day]['start_time'] }} - {{ $schedule[$day]['end_time'] }}
                                                    </small>
                                                @else
                                                    <span class="badge bg-secondary">Unavailable</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Settings Tab -->
                        <div class="tab-pane fade" id="settings-tab">
                            <div class="row g-4">
                                <!-- Account Settings -->
                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-body">
                                            <h6 class="card-title">Account Settings</h6>
                                            <div class="form-check form-switch mb-2">
                                                <input class="form-check-input" type="checkbox" id="accepting_clients" 
                                                       {{ $trainerProfile && $trainerProfile->accepting_new_clients ? 'checked' : '' }}>
                                                <label class="form-check-label" for="accepting_clients">
                                                    Accept new clients
                                                </label>
                                            </div>
                                            <div class="form-check form-switch mb-2">
                                                <input class="form-check-input" type="checkbox" id="email_notifications" checked>
                                                <label class="form-check-label" for="email_notifications">
                                                    Email notifications
                                                </label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="profile_visible" checked>
                                                <label class="form-check-label" for="profile_visible">
                                                    Profile visible to public
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Security Settings -->
                                <div class="col-md-6">
                                    <div class="card border">
                                        <div class="card-body">
                                            <h6 class="card-title">Security</h6>
                                            <button class="btn btn-outline-primary btn-sm mb-2 w-100">
                                                <i class="bi bi-key me-2"></i>Change Password
                                            </button>
                                            <button class="btn btn-outline-secondary btn-sm w-100">
                                                <i class="bi bi-shield-lock me-2"></i>Two-Factor Authentication
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Handle settings toggles
    document.getElementById('accepting_clients').addEventListener('change', function() {
        const isChecked = this.checked;
        // Here you would send an AJAX request to update the setting
        console.log('Accepting new clients:', isChecked);
    });

    // Handle other settings similarly
    document.getElementById('email_notifications').addEventListener('change', function() {
        console.log('Email notifications:', this.checked);
    });

    document.getElementById('profile_visible').addEventListener('change', function() {
        console.log('Profile visible:', this.checked);
    });
</script>
@endpush