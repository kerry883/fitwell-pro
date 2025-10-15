@extends('layouts.trainer')

@section('title', 'Program Details: ' . $program['name'])

@section('content')
<div class="container-fluid">
    <!-- Program Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('trainer.programs.index') }}">Programs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $program['name'] }}</li>
                </ol>
            </nav>
            <h1 class="h3 mb-1">{{ $program['name'] }}</h1>
            <p class="text-muted mb-0">{{ $program['description'] }}</p>
        </div>
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-cog me-1"></i> Actions
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('trainer.programs.edit', $program['id']) }}">
                    <i class="fas fa-edit me-2"></i> Edit Program
                </a></li>
                <li><a class="dropdown-item" href="#">
                    <i class="fas fa-copy me-2"></i> Duplicate Program
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#" onclick="deleteProgram({{ $program['id'] }})">
                    <i class="fas fa-trash me-2"></i> Delete Program
                </a></li>
            </ul>
        </div>
    </div>

    <div class="row">
        <!-- Program Details -->
        <div class="col-lg-8 mb-4">
            <!-- Program Overview -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Program Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong class="text-muted">Duration:</strong>
                                <span class="ms-2">{{ $program['duration'] }} weeks</span>
                            </div>
                            <div class="mb-3">
                                <strong class="text-muted">Difficulty Level:</strong>
                                <span class="badge bg-{{ $program['difficulty_color'] }} ms-2">{{ ucfirst($program['difficulty_level']) }}</span>
                            </div>
                            <div class="mb-3">
                                <strong class="text-muted">Program Type:</strong>
                                <span class="ms-2">{{ ucfirst(str_replace('_', ' ', $program['program_type'])) }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong class="text-muted">Sessions per Week:</strong>
                                <span class="ms-2">{{ $program['sessions_per_week'] }}</span>
                            </div>
                            <div class="mb-3">
                                <strong class="text-muted">Equipment Needed:</strong>
                                <span class="ms-2">{{ $program['equipment_needed'] ? 'Yes' : 'No' }}</span>
                            </div>
                            <div class="mb-3">
                                <strong class="text-muted">Active Clients:</strong>
                                <span class="ms-2">{{ $program['active_clients'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                    
                    @if($program['objectives'])
                    <div class="mt-4">
                        <strong class="text-muted">Program Objectives:</strong>
                        <ul class="mt-2">
                            @foreach($program['objectives'] as $objective)
                            <li>{{ $objective }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Program Schedule/Workouts -->
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Workout Schedule</h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addWorkoutModal">
                        <i class="fas fa-plus me-1"></i> Add Workout
                    </button>
                </div>
                <div class="card-body">
                    @if(isset($program['workouts']) && count($program['workouts']))
                        <div class="accordion" id="workoutAccordion">
                            @foreach($program['workouts'] as $index => $workout)
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" 
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" 
                                            aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                                        <div class="d-flex justify-content-between w-100 me-3">
                                            <div>
                                                <strong>Week {{ $workout['week'] }}, Day {{ $workout['day'] }}: {{ $workout['title'] }}</strong>
                                                <div class="text-muted small">{{ $workout['duration'] ?? 60 }} minutes</div>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-primary">{{ count($workout['exercises']) }} exercises</span>
                                            </div>
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                                     data-bs-parent="#workoutAccordion">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h6>Exercises:</h6>
                                                <div class="table-responsive">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Exercise</th>
                                                                <th>Sets</th>
                                                                <th>Reps</th>
                                                                <th>Rest</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($workout['exercises'] as $exercise)
                                                            <tr>
                                                                <td>{{ $exercise['name'] }}</td>
                                                                <td>{{ $exercise['sets'] }}</td>
                                                                <td>{{ $exercise['reps'] }}</td>
                                                                <td>{{ $exercise['rest'] }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                @if($workout['notes'])
                                                <h6>Notes:</h6>
                                                <p class="text-muted small">{{ $workout['notes'] }}</p>
                                                @endif
                                                
                                                @if($workout['focus_areas'])
                                                <h6>Focus Areas:</h6>
                                                <div class="d-flex flex-wrap gap-1">
                                                    @foreach($workout['focus_areas'] as $area)
                                                    <span class="badge bg-light text-dark">{{ $area }}</span>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-dumbbell fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No workouts added yet</h5>
                            <p class="text-muted">Start building your program by adding workouts</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addWorkoutModal">
                                <i class="fas fa-plus me-1"></i> Add First Workout
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Program Progress -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Client Progress</h5>
                </div>
                <div class="card-body">
                    @if(isset($program['client_progress']) && count($program['client_progress']))
                        <div class="row">
                            @foreach($program['client_progress'] as $progress)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <span class="avatar-initials bg-primary text-white">
                                            {{ substr($progress['client_name'], 0, 2) }}
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ $progress['client_name'] }}</strong>
                                            <span class="text-muted">{{ $progress['completion'] }}%</span>
                                        </div>
                                        <div class="progress mt-1" style="height: 6px;">
                                            <div class="progress-bar bg-success" style="width: {{ $progress['completion'] }}%"></div>
                                        </div>
                                        <small class="text-muted">Week {{ $progress['current_week'] }} of {{ $program['duration'] }}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-line fa-2x text-muted mb-3"></i>
                            <p class="text-muted">No clients assigned to this program yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Program Sidebar -->
        <div class="col-lg-4">
            <!-- Program Stats -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Program Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-primary mb-0">{{ $program['active_clients'] ?? 0 }}</h4>
                            <small class="text-muted">Active Clients</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-0">{{ $program['completion_rate'] ?? 0 }}%</h4>
                            <small class="text-muted">Avg Completion</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-info mb-0">{{ count($program['workouts'] ?? []) }}</h4>
                            <small class="text-muted">Total Workouts</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning mb-0">4.8</h4>
                            <small class="text-muted">Rating</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('trainer.programs.edit', $program['id']) }}" class="btn btn-outline-primary">
                            <i class="fas fa-edit me-2"></i> Edit Program
                        </a>
                        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#assignClientModal">
                            <i class="fas fa-user-plus me-2"></i> Assign to Client
                        </button>
                        <button class="btn btn-outline-info">
                            <i class="fas fa-share me-2"></i> Share Program
                        </button>
                        <button class="btn btn-outline-warning">
                            <i class="fas fa-download me-2"></i> Export PDF
                        </button>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    @if(isset($program['recent_activity']) && count($program['recent_activity']))
                        <div class="timeline">
                            @foreach($program['recent_activity'] as $activity)
                            <div class="timeline-item mb-3">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">{{ $activity['title'] }}</h6>
                                    <p class="text-muted mb-1">{{ $activity['description'] }}</p>
                                    <small class="text-muted">{{ $activity['time_ago'] }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-3">No recent activity</p>
                    @endif
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

.avatar-initials {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 12px;
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
    padding: 10px;
    border-radius: 8px;
}
</style>
@endpush

<script>
function deleteProgram(programId) {
    if (confirm('Are you sure you want to delete this program? This action cannot be undone.')) {
        // Add delete logic here
        alert('Delete functionality to be implemented');
    }
}
</script>
@endsection