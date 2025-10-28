@extends('layouts.trainer')

@section('title', $client['name'] . ' - Client Details')
@section('page-title', $client['name'])
@section('page-subtitle', 'Client since ' . \Carbon\Carbon::parse($client['joinedDate'])->format('F Y'))

@section('content')
<div class="row g-4">
    <!-- Back Button -->
    <div class="col-12">
        <a href="{{ route('trainer.clients.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Clients
        </a>
    </div>

    <!-- Client Overview -->
    <div class="col-md-4">
        <div class="card trainer-card">
            <div class="card-body text-center">
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 80px; height: 80px; font-size: 2rem;">
                    {{ substr($client['name'], 0, 1) }}
                </div>
                <h4 class="mb-1">{{ $client['name'] }}</h4>
                <p class="text-muted mb-3">{{ $client['email'] }}</p>
                
                <!-- Status Badge -->
                <span class="badge client-status-{{ $client['status'] }} mb-3">
                    {{ ucfirst($client['status']) }}
                </span>

                <!-- Quick Stats -->
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="bg-light rounded p-2">
                            <div class="fw-bold text-primary">{{ $clientStats['totalSessions'] }}</div>
                            <small class="text-muted">Total Sessions</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded p-2">
                            <div class="fw-bold text-success">{{ $clientStats['currentStreak'] }}</div>
                            <small class="text-muted">Day Streak</small>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-grid gap-2">
                    <button class="btn trainer-btn-primary">
                        <i class="bi bi-calendar-plus me-2"></i>Schedule Session
                    </button>
                    <button class="btn btn-outline-primary">
                        <i class="bi bi-chat-left-text me-2"></i>Send Message
                    </button>
                    <button class="btn btn-outline-secondary">
                        <i class="bi bi-pencil me-2"></i>Edit Client
                    </button>
                </div>
            </div>
        </div>

        <!-- Client Profile Information -->
        <div class="card trainer-card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Client Profile</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <small class="text-muted d-block">Fitness Level</small>
                            <span class="badge bg-info">{{ ucfirst($clientProfile->experience_level ?? 'Not specified') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <small class="text-muted d-block">Available Days/Week</small>
                            <span class="fw-bold">{{ $clientProfile->available_days_per_week ?? 'Not specified' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <small class="text-muted d-block">Preferred Workout Types</small>
                            @if($clientProfile->preferred_workout_types)
                                @foreach(json_decode($clientProfile->preferred_workout_types) as $type)
                                    <span class="badge bg-secondary me-1">{{ ucfirst($type) }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Not specified</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2">
                            <small class="text-muted d-block">Preferred Workout Duration</small>
                            <span class="fw-bold">{{ $clientProfile->workout_duration_preference ?? 'Not specified' }} min</span>
                        </div>
                    </div>
                    @if($clientProfile->medical_conditions || $clientProfile->injuries)
                    <div class="col-12">
                        <div class="alert alert-warning py-2">
                            <small class="fw-bold text-warning">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                Medical Considerations Present
                            </small>
                            <div class="mt-1">
                                @if($clientProfile->medical_conditions)
                                    <small class="text-muted d-block">Conditions: {{ implode(', ', json_decode($clientProfile->medical_conditions)) }}</small>
                                @endif
                                @if($clientProfile->injuries)
                                    <small class="text-muted d-block">Injuries: {{ implode(', ', json_decode($clientProfile->injuries)) }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Current Program -->
        @if($currentProgram)
        <div class="card trainer-card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-clipboard-check me-2"></i>Current Program</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-1">{{ $currentProgram->program->name }}</h6>
                        <p class="text-muted mb-2">{{ $currentProgram->program->description }}</p>
                        <div class="row g-2">
                            <div class="col-auto">
                                <small class="text-muted">Progress:</small>
                                <span class="badge bg-success">{{ $currentProgram->progress_percentage }}%</span>
                            </div>
                            <div class="col-auto">
                                <small class="text-muted">Week:</small>
                                <span class="fw-bold">{{ $currentProgram->current_week }}</span>
                            </div>
                            <div class="col-auto">
                                <small class="text-muted">Status:</small>
                                <span class="badge bg-primary">{{ ucfirst($currentProgram->status) }}</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('programs.show', $currentProgram->program_id) }}" class="btn btn-sm btn-outline-primary">
                        View Program
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Client Goals -->
        <div class="card trainer-card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-bullseye me-2"></i>Client Goals</h6>
                <small class="text-muted">
                    @if($clientGoals)
                        {{ count($clientGoals) }} active goals
                    @else
                        No goals set
                    @endif
                </small>
            </div>
            <div class="card-body">
                @if($clientGoals && count($clientGoals) > 0)
                    @foreach($clientGoals as $goal)
                        <div class="d-flex align-items-center mb-2">
                            @if($goal['type'] === 'client_set')
                                <i class="bi bi-person-circle text-primary me-2"></i>
                                <span class="text-primary">{{ $goal['title'] }}</span>
                                <small class="text-muted ms-2">(Client-defined)</small>
                            @else
                                <i class="bi bi-trophy text-success me-2"></i>
                                <span>{{ $goal['title'] }}</span>
                                <small class="text-muted ms-2">(Trainer-set)</small>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="bi bi-info-circle text-muted mb-2" style="font-size: 1.5rem;"></i>
                        <p class="text-muted mb-0">No goals set yet</p>
                        <small class="text-muted">Goals will be visible here once enrolled in a program</small>
                    </div>
                @endif
                <div class="alert alert-info mt-3 py-2">
                    <small class="text-info">
                        <i class="bi bi-info-circle-fill me-1"></i>
                        Client goals are used for program matching. Trainer-set goals appear after program enrollment.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="col-md-8">
        <!-- Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card trainer-card text-center">
                    <div class="card-body">
                        <div class="text-info mb-2">
                            <i class="bi bi-calendar-week" style="font-size: 1.5rem;"></i>
                        </div>
                        <h5 class="mb-1">{{ $clientStats['weeklyAverage'] }}</h5>
                        <small class="text-muted">Weekly Avg</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card trainer-card text-center">
                    <div class="card-body">
                        <div class="text-success mb-2">
                            <i class="bi bi-trophy" style="font-size: 1.5rem;"></i>
                        </div>
                        <h5 class="mb-1">{{ $clientStats['progressScore'] }}%</h5>
                        <small class="text-muted">Progress Score</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card trainer-card text-center">
                    <div class="card-body">
                        <div class="text-warning mb-2">
                            <i class="bi bi-fire" style="font-size: 1.5rem;"></i>
                        </div>
                        <h5 class="mb-1">{{ $clientStats['currentStreak'] }}</h5>
                        <small class="text-muted">Day Streak</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card trainer-card text-center">
                    <div class="card-body">
                        <div class="text-danger mb-2">
                            <i class="bi bi-x-circle" style="font-size: 1.5rem;"></i>
                        </div>
                        <h5 class="mb-1">{{ $clientStats['missedSessions'] }}</h5>
                        <small class="text-muted">Missed</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="card trainer-card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#progress-tab">
                            <i class="bi bi-graph-up me-2"></i>Progress
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#workouts-tab">
                            <i class="bi bi-activity me-2"></i>Workout History
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#schedule-tab">
                            <i class="bi bi-calendar me-2"></i>Schedule
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#goals-tab">
                            <i class="bi bi-trophy me-2"></i>Goals
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#notes-tab">
                            <i class="bi bi-journal-text me-2"></i>Notes
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <!-- Progress Tab -->
                    <div class="tab-pane fade show active" id="progress-tab">
                        <div class="row g-4">
                            <!-- Weight Progress -->
                            <div class="col-md-4">
                                <div class="bg-light rounded p-3">
                                    <h6 class="mb-3"><i class="bi bi-speedometer2 me-2"></i>Weight Progress</h6>
                                    <div class="text-center">
                                        @if($progressData['weightProgress']['current'])
                                            <div class="display-6 fw-bold text-primary mb-1">{{ $progressData['weightProgress']['current'] }} kg</div>
                                            <small class="text-muted">Current Weight</small>
                                            @if($progressData['bmi'])
                                                <div class="mt-1">
                                                    <small class="text-info">BMI: {{ $progressData['bmi'] }}</small>
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-muted">No weight data available</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Strength Progress -->
                            <div class="col-md-8">
                                <div class="bg-light rounded p-3">
                                    <h6 class="mb-3"><i class="bi bi-lightning me-2"></i>Strength Progress</h6>
                                    <div class="row g-3">
                                        @foreach($progressData['strengthProgress'] as $exercise => $data)
                                            <div class="col-md-4">
                                                <div class="text-center">
                                                    <div class="fw-bold text-primary">{{ $data['current'] }} kg</div>
                                                    <small class="text-muted d-block">{{ ucfirst(str_replace('_', ' ', $exercise)) }}</small>
                                                    <small class="text-success">
                                                        +{{ $data['current'] - $data['starting'] }} kg
                                                    </small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Body Measurements -->
                            <div class="col-12">
                                <div class="bg-light rounded p-3">
                                    <h6 class="mb-3"><i class="bi bi-rulers me-2"></i>Body Measurements</h6>
                                    @if(count($progressData['measurements']) > 0)
                                        <div class="row g-3">
                                            @foreach($progressData['measurements'] as $measurement => $data)
                                                <div class="col-md-4">
                                                    <div class="d-flex justify-content-between align-items-center p-2 bg-white rounded">
                                                        <div>
                                                            <div class="fw-bold">{{ ucfirst($measurement) }}</div>
                                                            <small class="text-muted">{{ $data['current'] }} cm</small>
                                                        </div>
                                                        <div class="text-end">
                                                            @if($data['starting'] && $data['current'] != $data['starting'])
                                                                <small class="text-success">
                                                                    @if($data['current'] > $data['starting'])
                                                                        <i class="bi bi-arrow-up"></i>
                                                                        +{{ number_format($data['current'] - $data['starting'], 1) }}
                                                                    @else
                                                                        <i class="bi bi-arrow-down"></i>
                                                                        {{ number_format($data['current'] - $data['starting'], 1) }}
                                                                    @endif
                                                                </small>
                                                            @else
                                                                <small class="text-muted">Current</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-center text-muted py-3">
                                            <i class="bi bi-info-circle me-2"></i>
                                            No body measurements recorded yet
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Workout History Tab -->
                    <div class="tab-pane fade" id="workouts-tab">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Workout</th>
                                        <th>Duration</th>
                                        <th>Performance</th>
                                        <th>Rating</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workoutHistory as $workout)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($workout['date'])->format('M j, Y') }}</td>
                                            <td>
                                                <div class="fw-bold">{{ $workout['workout'] }}</div>
                                            </td>
                                            <td>{{ $workout['duration'] }} min</td>
                                            <td>
                                                @if(isset($workout['sets']))
                                                    <small class="text-muted">{{ $workout['sets'] }} sets, {{ $workout['reps'] }} reps</small>
                                                @elseif(isset($workout['caloriesBurned']))
                                                    <small class="text-muted">{{ $workout['caloriesBurned'] }} calories</small>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="text-warning">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $workout['rating'])
                                                            <i class="bi bi-star-fill"></i>
                                                        @else
                                                            <i class="bi bi-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Schedule Tab -->
                    <div class="tab-pane fade" id="schedule-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Upcoming Sessions</h6>
                            <button class="btn btn-sm trainer-btn-primary" data-bs-toggle="modal" data-bs-target="#scheduleModal">
                                <i class="bi bi-plus me-1"></i>Schedule New
                            </button>
                        </div>

                        @if(count($clientSchedule) > 0)
                            <div class="list-group">
                                @foreach($clientSchedule as $session)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $session['date'] }} - {{ $session['time'] }}</h6>
                                        <p class="mb-1">{{ $session['session_type'] }}</p>
                                        <small class="text-muted">{{ $session['duration'] }} minutes @if($session['location']) at {{ $session['location'] }} @endif</small>
                                        @if($session['status'] === 'completed')
                                            <span class="badge bg-success ms-2">Completed</span>
                                        @elseif($session['status'] === 'missed')
                                            <span class="badge bg-danger ms-2">Missed</span>
                                        @elseif($session['status'] === 'cancelled')
                                            <span class="badge bg-warning ms-2">Cancelled</span>
                                        @else
                                            <span class="badge bg-primary ms-2">Scheduled</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="btn-group" role="group">
                                            @if($session['status'] === 'scheduled')
                                                <button class="btn btn-sm btn-success complete-session" data-session-id="{{ $session['id'] }}">Complete</button>
                                                <button class="btn btn-sm btn-warning mark-missed" data-session-id="{{ $session['id'] }}">Missed</button>
                                            @endif
                                            <button class="btn btn-sm btn-outline-primary edit-session" data-session-id="{{ $session['id'] }}">Edit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-calendar-x text-muted" style="font-size: 3rem;"></i>
                                <h6 class="text-muted mt-2">No upcoming sessions scheduled</h6>
                                <p class="text-muted">Schedule a new session to get started</p>
                            </div>
                        @endif
                    </div>

                    <!-- Goals Tab -->
                    <div class="tab-pane fade" id="goals-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Client Goals</h6>
                            <button class="btn btn-sm trainer-btn-primary" data-bs-toggle="modal" data-bs-target="#addGoalModal">
                                <i class="bi bi-plus me-1"></i>Add Goal
                            </button>
                        </div>

                        @if(count($clientGoals) > 0)
                            <div class="row g-3">
                                @foreach($clientGoals as $goal)
                                <div class="col-md-6">
                                    <div class="card h-100 border-left-primary">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div class="flex-grow-1">
                                                    <h6 class="card-title mb-1">{{ $goal['title'] }}</h6>
                                                    <small class="text-muted">{{ $goal['category'] }} • {{ $goal['type'] }}</small>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item edit-goal" href="#" data-goal-id="{{ $goal['id'] }}">Edit</a></li>
                                                        <li><a class="dropdown-item add-progress" href="#" data-goal-id="{{ $goal['id'] }}">Add Progress</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item text-danger delete-goal" href="#" data-goal-id="{{ $goal['id'] }}">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <small class="text-muted">Progress</small>
                                                    <small class="fw-bold">{{ $goal['progress_percentage'] }}%</small>
                                                </div>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                         style="width: {{ $goal['progress_percentage'] }}%"
                                                         aria-valuenow="{{ $goal['progress_percentage'] }}"
                                                         aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>

                                            <div class="row g-2 mb-2">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Target</small>
                                                    <small class="fw-bold">{{ $goal['target_value'] }} {{ $goal['target_unit'] ?? '' }}</small>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">Current</small>
                                                    <small class="fw-bold">{{ $goal['current_value'] ?? 'Not set' }} {{ $goal['target_unit'] ?? '' }}</small>
                                                </div>
                                            </div>

                                            @if($goal['target_date'])
                                            <div class="mb-2">
                                                <small class="text-muted d-block">Due Date</small>
                                                <small class="fw-bold {{ $goal['is_overdue'] ? 'text-danger' : '' }}">
                                                    {{ $goal['target_date'] }}
                                                    @if($goal['is_overdue'])
                                                        <i class="bi bi-exclamation-triangle-fill text-danger ms-1"></i>
                                                    @elseif($goal['days_remaining'] !== null && $goal['days_remaining'] <= 30)
                                                        ({{ $goal['days_remaining'] }} days left)
                                                    @endif
                                                </small>
                                            </div>
                                            @endif

                                            @if($goal['latest_tracking'])
                                            <div class="mt-2 pt-2 border-top">
                                                <small class="text-muted d-block">Last Update</small>
                                                <small>{{ $goal['latest_tracking']['value'] }} {{ $goal['target_unit'] ?? '' }} on {{ $goal['latest_tracking']['date'] }}</small>
                                            </div>
                                            @endif

                                            <div class="mt-2">
                                                <span class="badge bg-{{ $goal['status'] === 'completed' ? 'success' : ($goal['status'] === 'active' ? 'primary' : 'secondary') }}">
                                                    {{ $goal['status'] }}
                                                </span>
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $goal['priority'])
                                                        <i class="bi bi-star-fill text-warning ms-1" style="font-size: 0.7rem;"></i>
                                                    @else
                                                        <i class="bi bi-star text-muted ms-1" style="font-size: 0.7rem;"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-trophy display-4 text-muted mb-3"></i>
                                <h5 class="text-muted">No goals set yet</h5>
                                <p class="text-muted">Create goals to track your client's progress and achievements.</p>
                                <button class="btn trainer-btn-primary" data-bs-toggle="modal" data-bs-target="#addGoalModal">
                                    <i class="bi bi-plus me-1"></i>Create First Goal
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Notes Tab -->
                    <div class="tab-pane fade" id="notes-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Training Notes</h6>
                            <button class="btn btn-sm trainer-btn-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                                <i class="bi bi-plus me-1"></i>Add Note
                            </button>
                        </div>

                        @if(count($clientNotes) > 0)
                            <div class="timeline">
                                @foreach($clientNotes as $note)
                            <div class="timeline-item">
                                <div class="timeline-date">{{ \Carbon\Carbon::parse($note['created_at'])->format('M j') }}</div>
                                <div class="timeline-content">
                                    <div class="card border-left-primary">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <h6 class="card-title">{{ $note['title'] }}</h6>
                                                    <p class="card-text">{{ $note['content'] }}</p>
                                                    <small class="text-muted">{{ $note['created_at'] }} by {{ $note['trainer'] }}</small>
                                                    @if($note['type'] !== 'General Note')
                                                        <span class="badge bg-secondary ms-2">{{ $note['type'] }}</span>
                                                    @endif
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item edit-note" href="#" data-note-id="{{ $note['id'] }}" data-title="{{ $note['title'] }}" data-content="{{ $note['content'] }}" data-type="{{ strtolower(str_replace(' ', '_', $note['type'])) }}">Edit</a></li>
                                                        <li><a class="dropdown-item text-danger delete-note" href="#" data-note-id="{{ $note['id'] }}">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-journal-x text-muted" style="font-size: 3rem;"></i>
                                <h6 class="text-muted mt-2">No notes yet</h6>
                                <p class="text-muted">Add your first training note to track progress</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Note Modal -->
<div class="modal fade" id="addNoteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Training Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addNoteForm">
                    <div class="mb-3">
                        <label for="noteTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="noteTitle" name="title" placeholder="Note title..." required>
                    </div>
                    <div class="mb-3">
                        <label for="noteContent" class="form-label">Content</label>
                        <textarea class="form-control" id="noteContent" name="content" rows="4" placeholder="Add your note here..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="noteType" class="form-label">Type</label>
                        <select class="form-select" id="noteType" name="type" required>
                            <option value="general">General Note</option>
                            <option value="progress">Progress Update</option>
                            <option value="concern">Concern</option>
                            <option value="achievement">Achievement</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="isPrivate" name="is_private" value="1">
                            <label class="form-check-label" for="isPrivate">
                                Private note (only visible to you)
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn trainer-btn-primary" id="saveNoteBtn">Add Note</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Note Modal -->
<div class="modal fade" id="editNoteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Training Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editNoteForm">
                    <input type="hidden" id="editNoteId" name="note_id">
                    <div class="mb-3">
                        <label for="editNoteTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="editNoteTitle" name="title" placeholder="Note title..." required>
                    </div>
                    <div class="mb-3">
                        <label for="editNoteContent" class="form-label">Content</label>
                        <textarea class="form-control" id="editNoteContent" name="content" rows="4" placeholder="Add your note here..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editNoteType" class="form-label">Type</label>
                        <select class="form-select" id="editNoteType" name="type" required>
                            <option value="general">General Note</option>
                            <option value="progress">Progress Update</option>
                            <option value="concern">Concern</option>
                            <option value="achievement">Achievement</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="editIsPrivate" name="is_private" value="1">
                            <label class="form-check-label" for="editIsPrivate">
                                Private note (only visible to you)
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn trainer-btn-primary" id="updateNoteBtn">Update Note</button>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Session Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Schedule Training Session</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="scheduleForm">
                    <div class="mb-3">
                        <label for="sessionDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="sessionDate" name="scheduled_date" min="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="startTime" class="form-label">Start Time</label>
                                <input type="time" class="form-control" id="startTime" name="start_time" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="endTime" class="form-label">End Time (Optional)</label>
                                <input type="time" class="form-control" id="endTime" name="end_time">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="sessionType" class="form-label">Session Type</label>
                        <select class="form-select" id="sessionType" name="session_type" required>
                            <option value="training">Training Session</option>
                            <option value="consultation">Consultation</option>
                            <option value="assessment">Assessment</option>
                            <option value="check_in">Check-in</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location (Optional)</label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Gym location, online, etc.">
                    </div>
                    <div class="mb-3">
                        <label for="sessionNotes" class="form-label">Notes (Optional)</label>
                        <textarea class="form-control" id="sessionNotes" name="notes" rows="3" placeholder="Session focus, preparation notes, etc."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn trainer-btn-primary" id="scheduleSessionBtn">Schedule Session</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dee2e6;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }
    
    .timeline-date {
        position: absolute;
        left: -25px;
        top: 0;
        background: #fff;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: bold;
        color: #6c757d;
        border: 2px solid #dee2e6;
    }
    
    .timeline-content {
        margin-left: 20px;
    }
    
    .border-left-primary {
        border-left: 4px solid var(--trainer-primary) !important;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
const clientId = {{ $client['id'] }};

// Note Management
const addNoteForm = document.getElementById('addNoteForm');
const saveNoteBtn = document.getElementById('saveNoteBtn');

saveNoteBtn.addEventListener('click', function() {
    const formData = new FormData(addNoteForm);

    fetch(`/trainer/clients/${clientId}/notes`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            title: formData.get('title'),
            content: formData.get('content'),
            type: formData.get('type'),
            is_private: formData.get('is_private') ? 1 : 0
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload(); // Refresh to show new note
        } else {
            alert('Error adding note');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding note');
    });
});

// Edit Note
document.querySelectorAll('.edit-note').forEach(button => {
    button.addEventListener('click', function() {
        const noteId = this.getAttribute('data-note-id');
        const title = this.getAttribute('data-title');
        const content = this.getAttribute('data-content');
        const type = this.getAttribute('data-type');

        document.getElementById('editNoteId').value = noteId;
        document.getElementById('editNoteTitle').value = title;
        document.getElementById('editNoteContent').value = content;
        document.getElementById('editNoteType').value = type;

        new bootstrap.Modal(document.getElementById('editNoteModal')).show();
    });
});

// Update Note
document.getElementById('updateNoteBtn').addEventListener('click', function() {
    const noteId = document.getElementById('editNoteId').value;
    const formData = new FormData(document.getElementById('editNoteForm'));

    fetch(`/trainer/clients/${clientId}/notes/${noteId}`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            title: formData.get('title'),
            content: formData.get('content'),
            type: formData.get('type'),
            is_private: formData.get('is_private') ? 1 : 0
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error updating note');
        }
    });
});

// Delete Note
document.querySelectorAll('.delete-note').forEach(button => {
    button.addEventListener('click', function() {
        if (confirm('Are you sure you want to delete this note?')) {
            const noteId = this.getAttribute('data-note-id');

            fetch(`/trainer/clients/${clientId}/notes/${noteId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error deleting note');
                }
            });
        }
    });
});

// Schedule Management
const scheduleForm = document.getElementById('scheduleForm');
const scheduleSessionBtn = document.getElementById('scheduleSessionBtn');

scheduleSessionBtn.addEventListener('click', function() {
    const formData = new FormData(scheduleForm);

    fetch(`/trainer/clients/${clientId}/schedule`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            scheduled_date: formData.get('scheduled_date'),
            start_time: formData.get('start_time'),
            end_time: formData.get('end_time'),
            session_type: formData.get('session_type'),
            location: formData.get('location'),
            notes: formData.get('notes')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error scheduling session');
        }
    });
});

// Complete Session
document.querySelectorAll('.complete-session').forEach(button => {
    button.addEventListener('click', function() {
        const sessionId = this.getAttribute('data-session-id');
        const duration = prompt('Enter actual duration in minutes (optional):');

        fetch(`/trainer/clients/${clientId}/schedule/${sessionId}/complete`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                actual_duration_minutes: duration || null
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error completing session');
            }
        });
    });
});

// Mark Session as Missed
document.querySelectorAll('.mark-missed').forEach(button => {
    button.addEventListener('click', function() {
        if (confirm('Mark this session as missed?')) {
            const sessionId = this.getAttribute('data-session-id');

            fetch(`/trainer/clients/${clientId}/schedule/${sessionId}/missed`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error marking session as missed');
                }
            });
        }
    });
});
});

// Goal Management
const addGoalForm = document.getElementById('addGoalForm');
const saveGoalBtn = document.getElementById('saveGoalBtn');

saveGoalBtn.addEventListener('click', function() {
    const formData = new FormData(addGoalForm);

    fetch(`/trainer/clients/${clientId}/goals`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            title: formData.get('title'),
            description: formData.get('description'),
            category: formData.get('category'),
            type: formData.get('type'),
            measurement_type: formData.get('measurement_type'),
            target_value: formData.get('target_value'),
            target_unit: formData.get('target_unit'),
            current_value: formData.get('current_value'),
            target_date: formData.get('target_date'),
            priority: formData.get('priority')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show medical warnings if any
            if (data.warnings && data.warnings.length > 0) {
                let warningMessage = 'Medical Considerations Detected:\n\n';
                data.warnings.forEach(warning => {
                    warningMessage += '• ' + warning + '\n';
                });
                warningMessage += '\nPlease review these considerations before proceeding.';
                alert(warningMessage);
            }

            // Show recommendations if any
            if (data.recommendations && data.recommendations.length > 0) {
                let recMessage = 'Recommendations:\n\n';
                data.recommendations.forEach(rec => {
                    recMessage += '• ' + rec + '\n';
                });
                setTimeout(() => {
                    alert(recMessage);
                }, 500);
            }

            location.reload();
        } else {
            alert('Error creating goal');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error creating goal');
    });
});

// Edit Goal
document.querySelectorAll('.edit-goal').forEach(button => {
    button.addEventListener('click', function() {
        const goalId = this.getAttribute('data-goal-id');

        // Fetch goal data and populate edit modal
        fetch(`/trainer/clients/${clientId}/goals`)
            .then(response => response.json())
            .then(data => {
                const goal = data.goals.find(g => g.id == goalId);
                if (goal) {
                    document.getElementById('editGoalId').value = goal.id;
                    document.getElementById('editGoalTitle').value = goal.title;
                    document.getElementById('editGoalCategory').value = goal.category.replace(' ', '_').toLowerCase();
                    document.getElementById('editGoalType').value = goal.type.replace(' ', '_').toLowerCase();
                    document.getElementById('editTargetValue').value = goal.target_value;
                    document.getElementById('editTargetUnit').value = goal.target_unit || '';
                    document.getElementById('editGoalStatus').value = goal.status;

                    new bootstrap.Modal(document.getElementById('editGoalModal')).show();
                }
            });
    });
});

// Update Goal
document.getElementById('updateGoalBtn').addEventListener('click', function() {
    const goalId = document.getElementById('editGoalId').value;
    const formData = new FormData(document.getElementById('editGoalForm'));

    fetch(`/trainer/clients/${clientId}/goals/${goalId}`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            title: formData.get('title'),
            category: formData.get('category'),
            type: formData.get('type'),
            target_value: formData.get('target_value'),
            target_unit: formData.get('target_unit'),
            status: formData.get('status')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error updating goal');
        }
    });
});

// Add Progress to Goal
document.querySelectorAll('.add-progress').forEach(button => {
    button.addEventListener('click', function() {
        const goalId = this.getAttribute('data-goal-id');
        document.getElementById('progressGoalId').value = goalId;

        // Set unit hint
        fetch(`/trainer/clients/${clientId}/goals`)
            .then(response => response.json())
            .then(data => {
                const goal = data.goals.find(g => g.id == goalId);
                if (goal) {
                    document.getElementById('unitHint').textContent = goal.target_unit ? `Unit: ${goal.target_unit}` : '';
                }
            });

        new bootstrap.Modal(document.getElementById('addProgressModal')).show();
    });
});

// Save Progress
document.getElementById('saveProgressBtn').addEventListener('click', function() {
    const goalId = document.getElementById('progressGoalId').value;
    const formData = new FormData(document.getElementById('addProgressForm'));

    fetch(`/trainer/clients/${clientId}/goals/${goalId}/progress`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            value: formData.get('value'),
            tracking_date: formData.get('tracking_date'),
            notes: formData.get('notes')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error adding progress');
        }
    });
});

// Delete Goal
document.querySelectorAll('.delete-goal').forEach(button => {
    button.addEventListener('click', function() {
        if (confirm('Are you sure you want to delete this goal?')) {
            const goalId = this.getAttribute('data-goal-id');

            fetch(`/trainer/clients/${clientId}/goals/${goalId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error deleting goal');
                }
            });
        }
    });
});
});
</script>
@endpush