@extends('layouts.trainer')

@section('title', 'Activate Client')
@section('page-title', 'Client Activation')
@section('page-subtitle', 'Review client details and activate enrollment')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Client Activation</h4>
                <a href="{{ route('trainer.clients.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Back to Clients
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Client Profile Card -->
        <div class="col-lg-4 mb-4">
            <div class="trainer-card h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Client Profile</h5>

                    <!-- Profile Picture -->
                    <div class="text-center mb-4">
                        @if($client->profile_picture)
                            <img src="{{ Storage::url($client->profile_picture) }}" 
                                 alt="Profile" 
                                 class="rounded-circle" 
                                 style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto" 
                                 style="width: 120px; height: 120px;">
                                <i class="bi bi-person-circle text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Client Details -->
                    <div class="mb-3">
                        <h6 class="fw-bold mb-1">{{ $client->full_name }}</h6>
                        <p class="text-muted mb-1">{{ $client->email }}</p>
                        <p class="text-muted mb-1">{{ $client->phone ?? 'N/A' }}</p>
                        <p class="text-muted mb-0">Age: {{ $clientProfile->age ?? 'N/A' }}</p>
                    </div>

                    <hr>

                    <!-- Fitness Goals -->
                    <div class="mb-3">
                        <h6 class="fw-bold mb-2">Fitness Goals</h6>
                        @if($clientProfile && $clientProfile->goals)
                            @foreach(json_decode($clientProfile->goals) as $goal)
                                <span class="badge bg-primary me-2 mb-2">{{ $goal }}</span>
                            @endforeach
                        @else
                            <p class="text-muted">No goals specified</p>
                        @endif
                    </div>

                    <hr>

                    <!-- Fitness Level -->
                    <div class="mb-3">
                        <h6 class="fw-bold mb-2">Fitness Level</h6>
                        <div class="d-flex align-items-center">
                            <div class="progress flex-grow-1 me-3" style="height: 8px;">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: {{ $clientProfile->fitness_level ?? 50 }}%; background-color: var(--trainer-primary);">
                                </div>
                            </div>
                            <span class="text-muted">{{ $clientProfile->fitness_level ?? 50 }}%</span>
                        </div>
                    </div>

                    <hr>

                    <!-- Medical Information -->
                    <div>
                        <h6 class="fw-bold mb-2">Medical Information</h6>
                        <p class="text-muted mb-1">Conditions: {{ $clientProfile->medical_conditions ?? 'None' }}</p>
                        <p class="text-muted mb-0">Injuries: {{ $clientProfile->injuries ?? 'None' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Program Details & Match Percentage -->
        <div class="col-lg-8 mb-4">
            <div class="trainer-card h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4">Program Details & Match Analysis</h5>

                    <!-- Program Information -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">{{ $program->name }}</h6>
                        <p class="mb-3">{{ $program->description }}</p>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-clock text-primary me-2"></i>
                                    <span>Duration: {{ $program->duration ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-bar-chart text-primary me-2"></i>
                                    <span>Level: {{ $program->difficulty ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-calendar-check text-primary me-2"></i>
                                    <span>Sessions: {{ $program->sessions_count ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Match Percentage -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Client-Program Match Analysis</h6>

                        <div class="text-center mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle" 
                                 style="width: 150px; height: 150px; background-color: var(--trainer-primary); color: white;">
                                <div>
                                    <h1 class="mb-0">{{ $matchPercentage }}%</h1>
                                    <p class="mb-0">Match</p>
                                </div>
                            </div>
                        </div>

                        <!-- Match Breakdown -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2" 
                                         style="width: 60px; height: 60px; background-color: rgba(40, 167, 69, 0.2);">
                                        <i class="bi bi-heart-pulse-fill text-success" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <h6 class="fw-bold">Goals Alignment</h6>
                                    <p class="text-muted small">{{ number_format($program->match_data['scores']['goals'], 0) }}% Match</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2" 
                                         style="width: 60px; height: 60px; background-color: rgba(40, 167, 69, 0.2);">
                                        <i class="bi bi-activity text-success" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <h6 class="fw-bold">Fitness Level</h6>
                                    <p class="text-muted small">{{ number_format($program->match_data['scores']['difficulty'], 0) }}% Match</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-2" 
                                         style="width: 60px; height: 60px; background-color: rgba(40, 167, 69, 0.2);">
                                        <i class="bi bi-calendar-heart text-success" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <h6 class="fw-bold">Schedule</h6>
                                    <p class="text-muted small">{{ number_format($program->match_data['scores']['schedule'], 0) }}% Match</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Match Analysis Details -->
                    @if(isset($program->match_data))
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">Match Analysis Details</h6>
                            <div class="alert alert-info mb-0">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Recommendation:</strong> {{ ucfirst($program->match_data['recommendation']) }} match<br>
                                <strong>Overall Score:</strong> {{ number_format($program->match_data['total_score'], 1) }}%<br>
                                @if(!empty($program->match_data['warnings']))
                                    <strong>Warnings:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach($program->match_data['warnings'] as $warning)
                                            <li>{{ $warning }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Trainer Notes -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-2">Notes for Trainer</h6>
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Based on the client's profile and program requirements, this appears to be a good match.
                            The client's fitness level aligns well with the program difficulty, and their goals are compatible
                            with the expected outcomes.
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        @if($clientProfile->status === 'active')
                            <form method="POST" action="{{ route('trainer.clients.deactivate', $client->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-danger px-4" onclick="return confirm('Are you sure you want to deactivate this client?')">
                                    <i class="bi bi-x-circle me-2"></i>Deactivate Client
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('trainer.clients.process-activation', $client->id) }}">
                                @csrf
                                <button type="submit" class="btn trainer-btn-primary text-white px-4">
                                    <i class="bi bi-check-circle me-2"></i>Accept & Activate Client
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('trainer.clients.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Back to Clients
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection