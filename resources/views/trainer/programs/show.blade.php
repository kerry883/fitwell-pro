@extends('layouts.trainer')

@section('title', 'Program Details: ' . $program->name)

@section('content')
<div class="container-fluid">
    <!-- Program Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('trainer.programs.index') }}">Programs</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $program->name }}</li>
                </ol>
            </nav>
            <h1 class="h3 mb-1">{{ $program->name }}</h1>
            <p class="text-muted mb-0">{{ $program->description }}</p>
        </div>
        <div class="dropdown">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-cog me-1"></i> Actions
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('trainer.programs.edit', $program->id) }}">
                    <i class="fas fa-edit me-2"></i> Edit Program
                </a></li>
                <li><a class="dropdown-item" href="#">
                    <i class="fas fa-copy me-2"></i> Duplicate Program
                </a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#" onclick="deleteProgram({{ $program->id }})">
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
                                <span class="ms-2">{{ $program->duration_weeks }} weeks</span>
                            </div>
                            <div class="mb-3">
                                <strong class="text-muted">Difficulty Level:</strong>
                                <span class="badge bg-{{ $program->difficulty_level == 'beginner' ? 'success' : ($program->difficulty_level == 'intermediate' ? 'warning' : 'danger') }} ms-2">{{ ucfirst($program->difficulty_level) }}</span>
                            </div>
                            <div class="mb-3">
                                <strong class="text-muted">Program Type:</strong>
                                <span class="ms-2">{{ ucfirst(str_replace('_', ' ', $program->program_type)) }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong class="text-muted">Sessions per Week:</strong>
                                <span class="ms-2">{{ $program->sessions_per_week }}</span>
                            </div>
                            <div class="mb-3">
                                <strong class="text-muted">Status:</strong>
                                <span class="badge bg-{{ $program->status == 'published' ? 'success' : ($program->status == 'draft' ? 'secondary' : 'warning') }} ms-2">{{ ucfirst($program->status) }}</span>
                            </div>
                            <div class="mb-3">
                                <strong class="text-muted">Active Clients:</strong>
                                <span class="ms-2">{{ $program->assignments()->where('status', 'active')->count() }}</span>
                            </div>
                        </div>
                    </div>

                    @if($program->goals)
                    <div class="mt-4">
                        <strong class="text-muted">Program Goals:</strong>
                        <ul class="mt-2">
                            @foreach($program->goals as $goal)
                            <li>{{ $goal }}</li>
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
                    <a href="{{ route('trainer.programs.workouts.create', $program->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus me-1"></i> Add Workout
                    </a>
                </div>
                <div class="card-body">
                    @if($program->workouts && $program->workouts->count())
                        <div class="list-group">
                            @foreach($program->workouts->sortBy('workout_date') as $workout)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $workout->name }}</h6>
                                    <p class="mb-1 text-muted small">
                                        {{ ucfirst($workout->type) }} • {{ ucfirst($workout->difficulty) }} •
                                        {{ $workout->workout_date->format('M j, Y') }}
                                        @if($workout->duration_minutes)
                                            • {{ $workout->duration_minutes }} minutes
                                        @endif
                                    </p>
                                    @if($workout->description)
                                        <p class="mb-0 text-muted small">{{ Str::limit($workout->description, 100) }}</p>
                                    @endif
                                </div>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-{{ $workout->status == 'completed' ? 'success' : ($workout->status == 'in_progress' ? 'warning' : 'secondary') }} mt-2">
                                        {{ ucfirst(str_replace('_', ' ', $workout->status)) }}
                                    </span>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('trainer.programs.workouts.edit', [$program->id, $workout->id]) }}">
                                                <i class="fas fa-edit me-2"></i> Edit
                                            </a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#" onclick="deleteWorkout({{ $workout->id }})">
                                                <i class="fas fa-trash me-2"></i> Delete
                                            </a></li>
                                        </ul>
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
                            <a href="{{ route('trainer.programs.workouts.create', $program->id) }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Add First Workout
                            </a>
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
                    @if($assignedClients && count($assignedClients))
                        <div class="row">
                            @foreach($assignedClients as $client)
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <span class="avatar-initials bg-primary text-white">
                                            {{ substr($client['name'], 0, 2) }}
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <strong>{{ $client['name'] }}</strong>
                                            <span class="text-muted">{{ $client['progress'] }}%</span>
                                        </div>
                                        <div class="progress mt-1" style="height: 6px;">
                                            <div class="progress-bar bg-success" style="width: {{ $client['progress'] }}%"></div>
                                        </div>
                                        <small class="text-muted">Week {{ $client['current_week'] }} of {{ $program->duration_weeks }}</small>
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
                            <h4 class="text-primary mb-0">{{ $program->assignments()->where('status', 'active')->count() }}</h4>
                            <small class="text-muted">Active Clients</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-0">{{ $program->assignments()->avg('progress_percentage') ?: 0 }}%</h4>
                            <small class="text-muted">Avg Completion</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-info mb-0">{{ $program->workouts ? $program->workouts->count() : 0 }}</h4>
                            <small class="text-muted">Total Workouts</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning mb-0">{{ $program->assignments()->count() }}</h4>
                            <small class="text-muted">Total Assignments</small>
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
                        <a href="{{ route('trainer.programs.edit', $program->id) }}" class="btn btn-outline-primary">
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
                    @if($program->assignments && $program->assignments->count())
                        <div class="timeline">
                            @foreach($program->assignments->take(5) as $assignment)
                            <div class="timeline-item mb-3">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">{{ $assignment->user->name }} assigned</h6>
                                    <p class="text-muted mb-1">Started the program</p>
                                    <small class="text-muted">{{ $assignment->assigned_date->diffForHumans() }}</small>
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

function deleteWorkout(workoutId) {
    if (confirm('Are you sure you want to delete this workout? This action cannot be undone.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("trainer.programs.workouts.destroy", [$program->id, ":workoutId"]) }}'.replace(':workoutId', workoutId);

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';

        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
