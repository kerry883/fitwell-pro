@extends('layouts.trainer')

@section('title', 'My Clients')
@section('page-title', 'My Clients')
@section('page-subtitle', 'Manage your client roster and track their progress')

@section('content')
<div class="row g-4">
    <!-- Client Management Header -->
    <div class="col-12">
        <div class="card trainer-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-2">Client Management</h4>
                        <p class="text-muted mb-0">You currently have {{ count($clients) }} active clients</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <button class="btn trainer-btn-primary me-2">
                            <i class="bi bi-person-plus me-1"></i>Add New Client
                        </button>
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-download me-1"></i>Export Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clients Overview Cards -->
    <div class="col-12">
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card trainer-card text-center">
                    <div class="card-body">
                        <div class="text-success mb-2">
                            <i class="bi bi-people-fill" style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="mb-1">{{ count($clients) }}</h4>
                        <p class="text-muted mb-0">Total Clients</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card trainer-card text-center">
                    <div class="card-body">
                        <div class="text-info mb-2">
                            <i class="bi bi-calendar-check-fill" style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="mb-1">{{ collect($clients)->sum('sessionsCompleted') }}</h4>
                        <p class="text-muted mb-0">Total Sessions</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card trainer-card text-center">
                    <div class="card-body">
                        <div class="text-warning mb-2">
                            <i class="bi bi-graph-up-arrow" style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="mb-1">85%</h4>
                        <p class="text-muted mb-0">Progress Rate</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card trainer-card text-center">
                    <div class="card-body">
                        <div class="text-danger mb-2">
                            <i class="bi bi-heart-fill" style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="mb-1">92%</h4>
                        <p class="text-muted mb-0">Retention Rate</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Client Filters and Search -->
    <div class="col-12 mb-3">
        <div class="card trainer-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Search clients...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select">
                            <option value="">All Progress</option>
                            <option value="excellent">Excellent</option>
                            <option value="improving">Improving</option>
                            <option value="on-track">On Track</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select">
                            <option value="">Sort by</option>
                            <option value="name">Name</option>
                            <option value="joined">Join Date</option>
                            <option value="sessions">Sessions</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="btn-group w-100">
                            <button class="btn btn-outline-secondary active" title="Grid View">
                                <i class="bi bi-grid-3x3-gap"></i>
                            </button>
                            <button class="btn btn-outline-secondary" title="List View">
                                <i class="bi bi-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clients Grid -->
    <div class="col-12">
        <div class="row g-4">
            @foreach($clients as $client)
                <div class="col-md-6 col-lg-4">
                    <div class="card trainer-card h-100">
                        <div class="card-body">
                            <!-- Client Header -->
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 50px; height: 50px; font-size: 1.2rem;">
                                        {{ substr($client['name'], 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="mb-1">{{ $client['name'] }}</h5>
                                    <small class="text-muted">{{ $client['email'] }}</small>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('trainer.clients.show', $client['id']) }}">
                                            <i class="bi bi-eye me-2"></i>View Details
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="bi bi-calendar-plus me-2"></i>Schedule Session
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="bi bi-chat-left-text me-2"></i>Send Message
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="#">
                                            <i class="bi bi-person-x me-2"></i>Remove Client
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Client Stats -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <div class="fw-bold text-primary">{{ $client['sessionsCompleted'] }}</div>
                                        <small class="text-muted">Sessions</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <div class="fw-bold text-success">{{ \Carbon\Carbon::parse($client['joinedDate'])->diffInDays(now()) }}</div>
                                        <small class="text-muted">Days</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress & Status -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <small class="text-muted">Progress</small>
                                    <span class="badge 
                                        @if($client['progress'] == 'excellent') bg-success
                                        @elseif($client['progress'] == 'improving') bg-info
                                        @else bg-warning @endif">
                                        {{ ucfirst($client['progress']) }}
                                    </span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar 
                                        @if($client['progress'] == 'excellent') bg-success
                                        @elseif($client['progress'] == 'improving') bg-info
                                        @else bg-warning @endif" 
                                        style="width: 
                                        @if($client['progress'] == 'excellent') 90%
                                        @elseif($client['progress'] == 'improving') 70%
                                        @else 50% @endif">
                                    </div>
                                </div>
                            </div>

                            <!-- Goals -->
                            <div class="mb-3">
                                <small class="text-muted d-block mb-1">Current Goals:</small>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($client['currentGoals'] as $goal)
                                        <span class="badge bg-light text-dark">{{ $goal }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Session Info -->
                            <div class="mb-3">
                                <div class="row g-2 small">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Last Session:</span>
                                            <span>{{ \Carbon\Carbon::parse($client['lastSession'])->format('M j') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Next Session:</span>
                                            <span class="text-primary">{{ \Carbon\Carbon::parse($client['nextSession'])->format('M j, g:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-grid gap-2">
                                <a href="{{ route('trainer.clients.show', $client['id']) }}" 
                                   class="btn trainer-btn-primary btn-sm">
                                    <i class="bi bi-eye me-1"></i>View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if(count($clients) == 0)
            <div class="col-12">
                <div class="card trainer-card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-people text-muted" style="font-size: 4rem;"></i>
                        <h4 class="mt-3 mb-2">No Clients Yet</h4>
                        <p class="text-muted mb-4">Start building your client base by adding your first client.</p>
                        <button class="btn trainer-btn-primary">
                            <i class="bi bi-person-plus me-2"></i>Add Your First Client
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if(count($clients) > 0)
        <div class="col-12">
            <div class="card trainer-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Showing {{ count($clients) }} of {{ count($clients) }} clients</small>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item disabled">
                                    <span class="page-link">Previous</span>
                                </li>
                                <li class="page-item active">
                                    <span class="page-link">1</span>
                                </li>
                                <li class="page-item disabled">
                                    <span class="page-link">Next</span>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Search functionality
    document.querySelector('input[placeholder="Search clients..."]').addEventListener('input', function() {
        // Add search functionality here
        console.log('Searching for:', this.value);
    });

    // View toggle
    document.querySelectorAll('.btn-group button').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.btn-group button').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
@endpush