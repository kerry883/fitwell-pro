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
                                        <img src="{{ $profile['photo'] ?? '/images/default-avatar.png' }}" 
                                             alt="Profile Photo" class="rounded-circle" width="80" height="80"
                                             style="object-fit: cover;">
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
                                       value="{{ $profile['first_name'] }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" 
                                       value="{{ $profile['last_name'] }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ $profile['email'] }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="{{ $profile['phone'] ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Professional Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4" 
                                      placeholder="Tell clients about your experience, approach, and what makes you unique...">{{ $profile['bio'] ?? '' }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="years_experience" class="form-label">Years of Experience</label>
                                <input type="number" class="form-control" id="years_experience" name="years_experience" 
                                       value="{{ $profile['years_experience'] ?? 0 }}" min="0" max="50">
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="languages" class="form-label">Languages Spoken</label>
                                <input type="text" class="form-control" id="languages" name="languages" 
                                       value="{{ implode(', ', $profile['languages'] ?? ['English']) }}"
                                       placeholder="English, Spanish, French...">
                                <small class="text-muted">Separate multiple languages with commas</small>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update Personal Information
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Professional Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('trainer.profile.update') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="section" value="professional">

                        <!-- Certifications -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label mb-0">Certifications</label>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addCertification()">
                                    <i class="fas fa-plus me-1"></i> Add Certification
                                </button>
                            </div>
                            <div id="certifications-container">
                                @if(isset($profile['certifications']) && count($profile['certifications']))
                                    @foreach($profile['certifications'] as $index => $cert)
                                    <div class="certification-item card mb-2">
                                        <div class="card-body py-2">
                                            <div class="row align-items-center">
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control form-control-sm" 
                                                           name="certifications[{{ $index }}][name]" 
                                                           value="{{ $cert['name'] }}" placeholder="Certification name">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="text" class="form-control form-control-sm" 
                                                           name="certifications[{{ $index }}][organization]" 
                                                           value="{{ $cert['organization'] }}" placeholder="Organization">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="date" class="form-control form-control-sm" 
                                                           name="certifications[{{ $index }}][expiry_date]" 
                                                           value="{{ $cert['expiry_date'] }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-sm btn-outline-danger w-100" 
                                                            onclick="removeCertification(this)">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- Specializations -->
                        <div class="mb-4">
                            <label for="specializations" class="form-label">Specializations</label>
                            <div class="row">
                                @foreach(['Weight Loss', 'Muscle Building', 'Strength Training', 'Cardio', 'Flexibility', 'Sports Specific', 'Rehabilitation', 'Senior Fitness', 'Youth Training', 'Nutrition Coaching'] as $spec)
                                <div class="col-md-6 col-lg-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="specializations[]" value="{{ strtolower(str_replace(' ', '_', $spec)) }}"
                                               id="spec_{{ strtolower(str_replace(' ', '_', $spec)) }}"
                                               {{ in_array(strtolower(str_replace(' ', '_', $spec)), $profile['specializations'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="spec_{{ strtolower(str_replace(' ', '_', $spec)) }}">
                                            {{ $spec }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Service Areas -->
                        <div class="mb-4">
                            <label for="service_areas" class="form-label">Service Areas</label>
                            <div class="row">
                                @foreach(['In-Person Training', 'Online Training', 'Home Visits', 'Gym Sessions', 'Outdoor Training', 'Group Training'] as $area)
                                <div class="col-md-6 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="service_areas[]" value="{{ strtolower(str_replace(' ', '_', $area)) }}"
                                               id="area_{{ strtolower(str_replace(' ', '_', $area)) }}"
                                               {{ in_array(strtolower(str_replace(' ', '_', $area)), $profile['service_areas'] ?? []) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="area_{{ strtolower(str_replace(' ', '_', $area)) }}">
                                            {{ $area }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update Professional Information
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Package Rates -->
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Package Rates</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addPackage()">
                        <i class="fas fa-plus me-1"></i> Add Package
                    </button>
                </div>
                <div class="card-body">
                    <form action="{{ route('trainer.profile.rates') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div id="packages-container">
                            @if(isset($profile['package_rates']) && count($profile['package_rates']))
                                @foreach($profile['package_rates'] as $index => $package)
                                <div class="package-item card mb-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="mb-0">Package {{ $index + 1 }}</h6>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removePackage(this)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <input type="text" class="form-control form-control-sm" 
                                                       name="packages[{{ $index }}][name]" 
                                                       value="{{ $package['name'] }}" placeholder="Package name">
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <input type="number" class="form-control form-control-sm" 
                                                       name="packages[{{ $index }}][sessions]" 
                                                       value="{{ $package['sessions'] }}" placeholder="Sessions">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" class="form-control" 
                                                           name="packages[{{ $index }}][price]" 
                                                           value="{{ $package['price'] }}" step="0.01" placeholder="0.00">
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <input type="number" class="form-control form-control-sm" 
                                                       name="packages[{{ $index }}][duration_days]" 
                                                       value="{{ $package['duration_days'] }}" placeholder="Valid for (days)">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="text" class="form-control form-control-sm" 
                                                       name="packages[{{ $index }}][description]" 
                                                       value="{{ $package['description'] ?? '' }}" 
                                                       placeholder="Package description">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update Package Rates
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Availability -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Availability Schedule</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('trainer.profile.availability') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="row">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <div class="col-md-12 mb-3">
                                <div class="card">
                                    <div class="card-body py-2">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="availability[{{ strtolower($day) }}][enabled]" 
                                                           id="day_{{ strtolower($day) }}"
                                                           {{ isset($profile['availability'][strtolower($day)]['enabled']) && $profile['availability'][strtolower($day)]['enabled'] ? 'checked' : '' }}>
                                                    <label class="form-check-label fw-medium" for="day_{{ strtolower($day) }}">
                                                        {{ $day }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label form-label-sm">Start Time</label>
                                                <input type="time" class="form-control form-control-sm" 
                                                       name="availability[{{ strtolower($day) }}][start_time]" 
                                                       value="{{ $profile['availability'][strtolower($day)]['start_time'] ?? '09:00' }}">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label form-label-sm">End Time</label>
                                                <input type="time" class="form-control form-control-sm" 
                                                       name="availability[{{ strtolower($day) }}][end_time]" 
                                                       value="{{ $profile['availability'][strtolower($day)]['end_time'] ?? '18:00' }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label form-label-sm">Break Time</label>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <input type="time" class="form-control form-control-sm" 
                                                               name="availability[{{ strtolower($day) }}][break_start]" 
                                                               value="{{ $profile['availability'][strtolower($day)]['break_start'] ?? '12:00' }}"
                                                               placeholder="Break start">
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="time" class="form-control form-control-sm" 
                                                               name="availability[{{ strtolower($day) }}][break_end]" 
                                                               value="{{ $profile['availability'][strtolower($day)]['break_end'] ?? '13:00' }}"
                                                               placeholder="Break end">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i> Update Availability
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Profile Preview -->
            <div class="card shadow-sm mb-4 position-sticky" style="top: 20px;">
                <div class="card-header">
                    <h5 class="mb-0">Profile Preview</h5>
                </div>
                <div class="card-body text-center">
                    <div class="avatar-xl mx-auto mb-3">
                        <img src="{{ $profile['photo'] ?? '/images/default-avatar.png' }}" 
                             alt="Profile Photo" class="rounded-circle" width="80" height="80"
                             style="object-fit: cover;">
                    </div>
                    <h5 class="mb-1">{{ $profile['first_name'] }} {{ $profile['last_name'] }}</h5>
                    <p class="text-muted mb-2">{{ $profile['email'] }}</p>
                    
                    @if(isset($profile['specializations']) && count($profile['specializations']))
                    <div class="mb-3">
                        @foreach(array_slice($profile['specializations'], 0, 3) as $spec)
                        <span class="badge bg-light text-dark me-1">{{ ucwords(str_replace('_', ' ', $spec)) }}</span>
                        @endforeach
                        @if(count($profile['specializations']) > 3)
                        <span class="badge bg-light text-dark">+{{ count($profile['specializations']) - 3 }} more</span>
                        @endif
                    </div>
                    @endif

                    <div class="row text-center">
                        <div class="col-6">
                            <h6 class="text-primary mb-0">{{ $profile['years_experience'] ?? 0 }}</h6>
                            <small class="text-muted">Years Experience</small>
                        </div>
                        <div class="col-6">
                            <h6 class="text-success mb-0">{{ count($profile['certifications'] ?? []) }}</h6>
                            <small class="text-muted">Certifications</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Tips -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Profile Tips</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6 class="alert-heading">Complete your profile!</h6>
                        <ul class="mb-0 small">
                            <li>Add a professional photo</li>
                            <li>Write a compelling bio</li>
                            <li>List your certifications</li>
                            <li>Set your availability</li>
                            <li>Define your packages</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let certificationCount = {{ count($profile['certifications'] ?? []) }};
let packageCount = {{ count($profile['package_rates'] ?? []) }};

function addCertification() {
    const container = document.getElementById('certifications-container');
    const div = document.createElement('div');
    div.className = 'certification-item card mb-2';
    div.innerHTML = `
        <div class="card-body py-2">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm" 
                           name="certifications[${certificationCount}][name]" placeholder="Certification name">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm" 
                           name="certifications[${certificationCount}][organization]" placeholder="Organization">
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control form-control-sm" 
                           name="certifications[${certificationCount}][expiry_date]">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-outline-danger w-100" onclick="removeCertification(this)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    container.appendChild(div);
    certificationCount++;
}

function removeCertification(button) {
    button.closest('.certification-item').remove();
}

function addPackage() {
    const container = document.getElementById('packages-container');
    const div = document.createElement('div');
    div.className = 'package-item card mb-3';
    div.innerHTML = `
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h6 class="mb-0">Package ${packageCount + 1}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removePackage(this)">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2">
                    <input type="text" class="form-control form-control-sm" 
                           name="packages[${packageCount}][name]" placeholder="Package name">
                </div>
                <div class="col-md-2 mb-2">
                    <input type="number" class="form-control form-control-sm" 
                           name="packages[${packageCount}][sessions]" placeholder="Sessions">
                </div>
                <div class="col-md-3 mb-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" 
                               name="packages[${packageCount}][price]" step="0.01" placeholder="0.00">
                    </div>
                </div>
                <div class="col-md-3 mb-2">
                    <input type="number" class="form-control form-control-sm" 
                           name="packages[${packageCount}][duration_days]" placeholder="Valid for (days)">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <input type="text" class="form-control form-control-sm" 
                           name="packages[${packageCount}][description]" placeholder="Package description">
                </div>
            </div>
        </div>
    `;
    container.appendChild(div);
    packageCount++;
}

function removePackage(button) {
    if (confirm('Remove this package?')) {
        button.closest('.package-item').remove();
    }
}
</script>
@endpush

@push('styles')
<style>
.avatar-xl {
    width: 80px;
    height: 80px;
}

.form-label-sm {
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}
</style>
@endpush
@endsection