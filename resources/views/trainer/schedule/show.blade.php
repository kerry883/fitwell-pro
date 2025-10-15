@extends('layouts.trainer')

@section('title', 'Session Details')

@section('content')
<div class="container-fluid">
    <!-- Session Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('trainer.schedule.index') }}">Schedule</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Session Details</li>
                </ol>
            </nav>
            <h1 class="h3 mb-1">{{ $session['title'] }}</h1>
            <p class="text-muted mb-0">{{ $session['date'] }} at {{ $session['time'] }}</p>
        </div>
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-cog me-1"></i> Actions
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('trainer.schedule.edit', $session['id']) }}">
                    <i class="fas fa-edit me-2"></i> Edit Session
                </a></li>
                <li><a class="dropdown-item" href="#">
                    <i class="fas fa-copy me-2"></i> Duplicate Session
                </a></li>
                <li><hr class="dropdown-divider"></li>
                @if($session['status'] !== 'completed')
                <li><a class="dropdown-item" href="#" onclick="markCompleted({{ $session['id'] }})">
                    <i class="fas fa-check me-2"></i> Mark as Completed
                </a></li>
                @endif
                @if($session['status'] === 'scheduled')
                <li><a class="dropdown-item" href="#" onclick="cancelSession({{ $session['id'] }})">
                    <i class="fas fa-times me-2"></i> Cancel Session
                </a></li>
                @endif
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#" onclick="deleteSession({{ $session['id'] }})">
                    <i class="fas fa-trash me-2"></i> Delete Session
                </a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <!-- Session Details -->
        <div class="col-lg-8 mb-4">
            <!-- Session Overview -->
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Session Overview</h5>
                    <span class="badge bg-{{ $session['status_color'] }} fs-6">{{ ucfirst($session['status']) }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong class="text-muted">Client:</strong>
                                <div class="d-flex align-items-center mt-1">
                                    <div class="avatar-sm me-2">
                                        <span class="avatar-initials bg-primary text-white">
                                            {{ substr($session['client_name'], 0, 2) }}
                                        </span>
                                    </div>
                                    <span>{{ $session['client_name'] }}</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong class="text-muted">Date & Time:</strong>
                                <div class="mt-1">
                                    <i class="fas fa-calendar me-2 text-primary"></i>{{ $session['date'] }}
                                    <br>
                                    <i class="fas fa-clock me-2 text-primary"></i>{{ $session['start_time'] }} - {{ $session['end_time'] }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong class="text-muted">Duration:</strong>
                                <span class="ms-2">{{ $session['duration'] }} minutes</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong class="text-muted">Session Type:</strong>
                                <span class="ms-2">{{ ucfirst(str_replace('_', ' ', $session['session_type'])) }}</span>
                            </div>
                            <div class="mb-3">
                                <strong class="text-muted">Location:</strong>
                                <div class="mt-1">
                                    <i class="fas fa-map-marker-alt me-2 text-danger"></i>{{ $session['location'] }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong class="text-muted">Rate:</strong>
                                <span class="ms-2">${{ number_format($session['rate'], 2) }}</span>
                            </div>
                        </div>
                    </div>

                    @if($session['description'])
                    <div class="mt-3">
                        <strong class="text-muted">Session Description:</strong>
                        <p class="mt-2 mb-0">{{ $session['description'] }}</p>
                    </div>
                    @endif

                    @if($session['goals'])
                    <div class="mt-3">
                        <strong class="text-muted">Session Goals:</strong>
                        <ul class="mt-2 mb-0">
                            @foreach($session['goals'] as $goal)
                            <li>{{ $goal }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Workout Plan -->
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Workout Plan</h5>
                    @if($session['status'] !== 'completed')
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editWorkoutModal">
                        <i class="fas fa-edit me-1"></i> Edit Workout
                    </button>
                    @endif
                </div>
                <div class="card-body">
                    @if(isset($session['workout']) && count($session['workout']['exercises']))
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Exercise</th>
                                        <th>Sets</th>
                                        <th>Reps/Duration</th>
                                        <th>Rest</th>
                                        <th>Weight/Notes</th>
                                        @if($session['status'] === 'completed')
                                        <th>Completed</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($session['workout']['exercises'] as $exercise)
                                    <tr>
                                        <td>
                                            <strong>{{ $exercise['name'] }}</strong>
                                            @if($exercise['muscle_group'])
                                            <br><small class="text-muted">{{ $exercise['muscle_group'] }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $exercise['sets'] }}</td>
                                        <td>{{ $exercise['reps'] ?? $exercise['duration'] }}</td>
                                        <td>{{ $exercise['rest'] }}</td>
                                        <td>
                                            @if($exercise['weight'])
                                                {{ $exercise['weight'] }}
                                            @endif
                                            @if($exercise['notes'])
                                                <br><small class="text-muted">{{ $exercise['notes'] }}</small>
                                            @endif
                                        </td>
                                        @if($session['status'] === 'completed')
                                        <td>
                                            @if($exercise['completed'] ?? false)
                                                <i class="fas fa-check-circle text-success"></i>
                                            @else
                                                <i class="fas fa-times-circle text-danger"></i>
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($session['workout']['notes'])
                        <div class="mt-3 p-3 bg-light rounded">
                            <strong class="text-muted">Workout Notes:</strong>
                            <p class="mt-1 mb-0">{{ $session['workout']['notes'] }}</p>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-dumbbell fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No workout planned</h5>
                            <p class="text-muted">Add exercises to this session</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editWorkoutModal">
                                <i class="fas fa-plus me-1"></i> Plan Workout
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Session Notes -->
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Session Notes & Progress</h5>
                    @if($session['status'] !== 'completed')
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addNotesModal">
                        <i class="fas fa-plus me-1"></i> Add Notes
                    </button>
                    @endif
                </div>
                <div class="card-body">
                    @if(isset($session['notes']) && count($session['notes']))
                        <div class="timeline">
                            @foreach($session['notes'] as $note)
                            <div class="timeline-item mb-3">
                                <div class="timeline-marker bg-{{ $note['type'] === 'progress' ? 'success' : 'primary' }}"></div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $note['title'] ?? 'Session Note' }}</h6>
                                            <p class="mb-2">{{ $note['content'] }}</p>
                                            <small class="text-muted">{{ $note['created_at'] ?? 'Just now' }}</small>
                                        </div>
                                        <span class="badge bg-{{ $note['type'] === 'progress' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($note['type']) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-sticky-note fa-2x mb-3"></i>
                            <p>No session notes yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Info -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Quick Info</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Session Status:</span>
                        <span class="badge bg-{{ $session['status_color'] }}">{{ ucfirst($session['status']) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Payment Status:</span>
                        <span class="badge bg-{{ $session['payment_status'] === 'paid' ? 'success' : 'warning' }}">
                            {{ ucfirst($session['payment_status']) }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Session Rate:</span>
                        <strong>${{ number_format($session['rate'], 2) }}</strong>
                    </div>
                    @if($session['recurring'])
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Recurring:</span>
                        <span>{{ ucfirst($session['recurring_type']) }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Client Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Client Information</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-lg me-3">
                            <span class="avatar-initials bg-primary text-white fs-4">
                                {{ substr($session['client_name'], 0, 2) }}
                            </span>
                        </div>
                        <div>
                            <h6 class="mb-1">{{ $session['client_name'] }}</h6>
                            <p class="text-muted mb-0">{{ $session['client_email'] }}</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong class="text-muted">Fitness Goals:</strong>
                        <div class="mt-1">
                            @foreach($session['client_goals'] ?? [] as $goal)
                            <span class="badge bg-light text-dark me-1">{{ $goal }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-user me-1"></i> View Client Profile
                        </a>
                        <a href="#" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-chart-line me-1"></i> View Progress
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($session['status'] === 'scheduled')
                        <button class="btn btn-success" onclick="markCompleted({{ $session['id'] }})">
                            <i class="fas fa-check me-2"></i> Mark Completed
                        </button>
                        <button class="btn btn-warning" onclick="rescheduleSession({{ $session['id'] }})">
                            <i class="fas fa-calendar-alt me-2"></i> Reschedule
                        </button>
                        @endif
                        
                        <a href="{{ route('trainer.schedule.edit', $session['id']) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i> Edit Session
                        </a>
                        
                        @if($session['recurring'])
                        <button class="btn btn-outline-info">
                            <i class="fas fa-repeat me-2"></i> Manage Recurring
                        </button>
                        @endif
                        
                        <button class="btn btn-outline-secondary">
                            <i class="fas fa-envelope me-2"></i> Send Reminder
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.avatar-sm {
    width: 32px;
    height: 32px;
}

.avatar-lg {
    width: 48px;
    height: 48px;
}

.avatar-initials {
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-weight: bold;
}

.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background-color: #e9ecef;
}

.timeline-item {
    position: relative;
}

.timeline-marker {
    position: absolute;
    left: -25px;
    top: 5px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid #fff;
}

.timeline-content {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
}
</style>
@endpush

<script>
function markCompleted(sessionId) {
    if (confirm('Mark this session as completed?')) {
        // Add completion logic here
        alert('Session marked as completed');
        location.reload();
    }
}

function cancelSession(sessionId) {
    if (confirm('Cancel this session? The client will be notified.')) {
        // Add cancellation logic here
        alert('Session cancelled');
        location.reload();
    }
}

function rescheduleSession(sessionId) {
    // Add reschedule logic here
    alert('Reschedule functionality to be implemented');
}

function deleteSession(sessionId) {
    if (confirm('Are you sure you want to delete this session? This action cannot be undone.')) {
        // Add delete logic here
        alert('Delete functionality to be implemented');
    }
}
</script>
@endsection