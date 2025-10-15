@extends('layouts.trainer')

@section('title', 'Schedule Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Schedule Management</h4>
            <p class="text-muted mb-0">Manage your training sessions and availability</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('trainer.schedule.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Schedule Session
            </a>
            <button class="btn btn-outline-primary">
                <i class="fas fa-download me-2"></i>Export Calendar
            </button>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 bg-primary bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-day text-primary fs-2"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-0">{{ count($schedule['today']) }}</h4>
                            <p class="text-muted mb-0">Today's Sessions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-success bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-week text-success fs-2"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-0">{{ count($schedule['week']) * 2 }}</h4>
                            <p class="text-muted mb-0">This Week</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-info bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-chart-line text-info fs-2"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-0">{{ $schedule['month']['completed_sessions'] }}</h4>
                            <p class="text-muted mb-0">Completed This Month</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-warning bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-dollar-sign text-warning fs-2"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-0">${{ number_format($schedule['month']['revenue']) }}</h4>
                            <p class="text-muted mb-0">Monthly Revenue</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Today's Schedule -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-day text-primary me-2"></i>
                            Today's Schedule
                        </h5>
                        <small class="text-muted">{{ $currentDate->format('l, F j, Y') }}</small>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($schedule['today']) > 0)
                        <div class="timeline">
                            @foreach($schedule['today'] as $session)
                            <div class="timeline-item">
                                <div class="timeline-marker 
                                    @if($session['status'] === 'completed') bg-success 
                                    @elseif($session['status'] === 'upcoming') bg-primary 
                                    @else bg-warning @endif">
                                </div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <div class="d-flex align-items-center mb-1">
                                                <span class="fw-bold">{{ $session['start_time'] }} - {{ $session['end_time'] }}</span>
                                                <span class="badge ms-2 
                                                    @if($session['status'] === 'completed') bg-success 
                                                    @elseif($session['status'] === 'upcoming') bg-primary 
                                                    @else bg-warning @endif">
                                                    {{ ucfirst($session['status']) }}
                                                </span>
                                            </div>
                                            <h6 class="mb-1">{{ $session['client_name'] }}</h6>
                                            <p class="text-muted mb-0">
                                                <i class="fas fa-dumbbell me-1"></i>{{ $session['session_type'] }}
                                                <i class="fas fa-map-marker-alt ms-3 me-1"></i>{{ $session['location'] }}
                                            </p>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('trainer.schedule.show', $session['id']) }}">View Details</a></li>
                                                <li><a class="dropdown-item" href="{{ route('trainer.schedule.edit', $session['id']) }}">Edit Session</a></li>
                                                @if($session['status'] === 'upcoming')
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#">Cancel Session</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times text-muted fs-1 mb-3"></i>
                            <p class="text-muted">No sessions scheduled for today</p>
                            <a href="{{ route('trainer.schedule.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Schedule a Session
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Weekly Calendar View -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-week text-primary me-2"></i>
                            This Week
                        </h5>
                        <div>
                            <button class="btn btn-outline-primary btn-sm me-2">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($schedule['week'] as $dayData)
                        <div class="col">
                            <div class="text-center mb-3">
                                <div class="fw-bold">{{ $dayData['date']->format('M j') }}</div>
                                <div class="text-muted small">{{ $dayData['date']->format('D') }}</div>
                            </div>
                            <div class="calendar-day">
                                @foreach($dayData['sessions'] as $session)
                                <div class="calendar-session bg-primary bg-opacity-10 p-2 mb-2 rounded">
                                    <div class="small fw-bold">{{ $session['time'] }}</div>
                                    <div class="small">{{ $session['client_name'] }}</div>
                                    <div class="small text-muted">{{ $session['type'] }}</div>
                                </div>
                                @endforeach
                                @if(count($dayData['sessions']) === 0)
                                    <div class="text-muted small text-center py-3">No sessions</div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('trainer.schedule.create') }}" class="btn btn-primary">
                            <i class="fas fa-calendar-plus me-2"></i>Schedule Session
                        </a>
                        <button class="btn btn-outline-primary">
                            <i class="fas fa-clock me-2"></i>Set Availability
                        </button>
                        <button class="btn btn-outline-success">
                            <i class="fas fa-repeat me-2"></i>Create Recurring
                        </button>
                        <button class="btn btn-outline-info">
                            <i class="fas fa-bell me-2"></i>Send Reminders
                        </button>
                    </div>
                </div>
            </div>

            <!-- Availability -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="mb-0">
                        <i class="fas fa-clock text-info me-2"></i>
                        Weekly Availability
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($availability as $day => $hours)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="fw-bold">{{ ucfirst($day) }}</div>
                        <div class="text-muted">
                            @if(is_array($hours))
                                {{ implode(', ', $hours) }}
                            @else
                                {{ $hours }}
                            @endif
                        </div>
                    </div>
                    @endforeach
                    <button class="btn btn-outline-primary btn-sm w-100 mt-3">
                        <i class="fas fa-edit me-2"></i>Update Availability
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 25px;
}

.timeline-item:before {
    content: '';
    position: absolute;
    left: -24px;
    top: 30px;
    bottom: -25px;
    width: 2px;
    background-color: #e9ecef;
}

.timeline-item:last-child:before {
    display: none;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 3px #e9ecef;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid var(--trainer-primary);
}

.calendar-day {
    min-height: 100px;
}

.calendar-session {
    cursor: pointer;
    transition: all 0.2s ease;
}

.calendar-session:hover {
    background-color: var(--trainer-primary) !important;
    color: white !important;
}

.calendar-session:hover .text-muted {
    color: rgba(255,255,255,0.8) !important;
}
</style>
@endsection