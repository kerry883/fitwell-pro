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

        <!-- Client Goals -->
        <div class="card trainer-card mt-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-bullseye me-2"></i>Current Goals</h6>
            </div>
            <div class="card-body">
                @foreach($client['currentGoals'] as $goal)
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-check-circle text-success me-2"></i>
                        <span>{{ $goal }}</span>
                    </div>
                @endforeach
                <button class="btn btn-sm btn-outline-primary w-100 mt-2">
                    <i class="bi bi-plus me-1"></i>Add Goal
                </button>
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
                                        <div class="display-6 fw-bold text-primary mb-1">{{ $progressData['weightProgress']['current'] }} kg</div>
                                        <small class="text-muted">Current Weight</small>
                                        <div class="mt-2">
                                            <small class="text-success">
                                                <i class="bi bi-arrow-down"></i>
                                                {{ $progressData['weightProgress']['starting'] - $progressData['weightProgress']['current'] }} kg lost
                                            </small>
                                        </div>
                                        <div class="progress mt-2" style="height: 6px;">
                                            <div class="progress-bar bg-success" style="width: 65%"></div>
                                        </div>
                                        <small class="text-muted">Goal: {{ $progressData['weightProgress']['goal'] }} kg</small>
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
                                    <div class="row g-3">
                                        @foreach($progressData['measurements'] as $measurement => $data)
                                            <div class="col-md-4">
                                                <div class="d-flex justify-content-between align-items-center p-2 bg-white rounded">
                                                    <div>
                                                        <div class="fw-bold">{{ ucfirst($measurement) }}</div>
                                                        <small class="text-muted">{{ $data['current'] }} cm</small>
                                                    </div>
                                                    <div class="text-end">
                                                        @if($data['current'] != $data['starting'])
                                                            <small class="text-success">
                                                                @if($data['current'] > $data['starting'])
                                                                    <i class="bi bi-arrow-up"></i>
                                                                    +{{ $data['current'] - $data['starting'] }}
                                                                @else
                                                                    <i class="bi bi-arrow-down"></i>
                                                                    {{ $data['current'] - $data['starting'] }}
                                                                @endif
                                                            </small>
                                                        @else
                                                            <small class="text-muted">No change</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
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
                            <button class="btn btn-sm trainer-btn-primary">
                                <i class="bi bi-plus me-1"></i>Schedule New
                            </button>
                        </div>
                        
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">Tomorrow - 2:00 PM</h6>
                                        <p class="mb-1">Strength Training Session</p>
                                        <small class="text-muted">60 minutes</small>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-outline-primary">Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Tab -->
                    <div class="tab-pane fade" id="notes-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Training Notes</h6>
                            <button class="btn btn-sm trainer-btn-primary" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                                <i class="bi bi-plus me-1"></i>Add Note
                            </button>
                        </div>
                        
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-date">Today</div>
                                <div class="timeline-content">
                                    <div class="card border-left-primary">
                                        <div class="card-body">
                                            <h6 class="card-title">Excellent form on squats today</h6>
                                            <p class="card-text">Client showed significant improvement in squat depth and stability. Ready to increase weight next session.</p>
                                            <small class="text-muted">2 hours ago</small>
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

<!-- Add Note Modal -->
<div class="modal fade" id="addNoteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Training Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="noteTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="noteTitle" placeholder="Note title...">
                    </div>
                    <div class="mb-3">
                        <label for="noteContent" class="form-label">Content</label>
                        <textarea class="form-control" id="noteContent" rows="4" placeholder="Add your note here..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="noteType" class="form-label">Type</label>
                        <select class="form-select" id="noteType">
                            <option value="general">General Note</option>
                            <option value="progress">Progress Update</option>
                            <option value="concern">Concern</option>
                            <option value="achievement">Achievement</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn trainer-btn-primary">Add Note</button>
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