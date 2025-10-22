@extends('layouts.trainer')

@section('title', 'Training Programs')
@section('page-title', 'Training Programs')
@section('page-subtitle', 'Create and manage your training programs')

@section('content')
<div class="row g-4">
    <!-- Programs Header -->
    <div class="col-12">
        <div class="card trainer-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-2">Program Management</h4>
                        <p class="text-muted mb-0">You have {{ count($programs) }} active training programs</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="{{ route('trainer.programs.create') }}" class="btn trainer-btn-primary me-2">
                            <i class="bi bi-plus-circle me-1"></i>Create New Program
                        </a>
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-download me-1"></i>Export Programs
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Program Statistics -->
    <div class="col-12">
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card trainer-card text-center">
                    <div class="card-body">
                        <div class="text-primary mb-2">
                            <i class="bi bi-journal-text" style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="mb-1">{{ count($programs) }}</h4>
                        <p class="text-muted mb-0">Total Programs</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card trainer-card text-center">
                    <div class="card-body">
                        <div class="text-success mb-2">
                            <i class="bi bi-people-fill" style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="mb-1">{{ collect($programs)->sum('active_clients') }}</h4>
                        <p class="text-muted mb-0">Active Clients</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card trainer-card text-center">
                    <div class="card-body">
                        <div class="text-info mb-2">
                            <i class="bi bi-graph-up" style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="mb-1">85%</h4>
                        <p class="text-muted mb-0">Completion Rate</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card trainer-card text-center">
                    <div class="card-body">
                        <div class="text-warning mb-2">
                            <i class="bi bi-star-fill" style="font-size: 2rem;"></i>
                        </div>
                        <h4 class="mb-1">4.7</h4>
                        <p class="text-muted mb-0">Average Rating</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter and Search -->
    <div class="col-12">
        <div class="card trainer-card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Search programs...">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select">
                            <option value="">All Types</option>
                            <option value="strength">Strength Training</option>
                            <option value="cardio">Cardio/HIIT</option>
                            <option value="powerlifting">Powerlifting</option>
                            <option value="weight-loss">Weight Loss</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select">
                            <option value="">All Levels</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select">
                            <option value="">Sort by</option>
                            <option value="name">Name</option>
                            <option value="created">Created Date</option>
                            <option value="clients">Client Count</option>
                            <option value="duration">Duration</option>
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

    <!-- Programs Grid -->
    <div class="col-12">
        <div class="row g-4">
            @foreach($programs as $program)
                <div class="col-md-6 col-lg-4">
                    <div class="card trainer-card h-100">
                        <div class="card-body">
                            <!-- Program Header -->
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-1">{{ $program['name'] }}</h5>
                                    <span class="badge 
                                        @if($program['difficulty_level'] == 'beginner') bg-success
                                        @elseif($program['difficulty_level'] == 'intermediate') bg-warning
                                        @else bg-danger @endif
                                        text-white">
                                        {{ ucfirst($program['difficulty_level']) }}
                                    </span>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a class="dropdown-item" href="{{ route('trainer.programs.show', $program['id']) }}">
                                            <i class="bi bi-eye me-2"></i>View Details
                                        </a>
                                        <a class="dropdown-item" href="{{ route('trainer.programs.edit', $program['id']) }}">
                                            <i class="bi bi-pencil me-2"></i>Edit Program
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            <i class="bi bi-files me-2"></i>Duplicate
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <button class="dropdown-item text-danger" onclick="deleteProgram({{ $program['id'] }})">
                                            <i class="bi bi-trash me-2"></i>Delete
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Program Type -->
                            <div class="mb-3">
                                <small class="text-muted">Program Type</small>
                                <div class="fw-bold text-primary">{{ $program['program_type'] }}</div>
                            </div>

                            <!-- Program Stats -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <div class="fw-bold text-info">{{ $program['duration_weeks'] }}</div>
                                        <small class="text-muted">Weeks</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center p-2 bg-light rounded">
                                        <div class="fw-bold text-success">{{ $program['sessions_per_week'] }}</div>
                                        <small class="text-muted">Sessions/Week</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="card-text text-muted small">
                                {{ Str::limit($program['description'], 100) }}
                            </p>

                            <!-- Active Clients -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <small class="text-muted">Active Clients</small>
                                <span class="badge bg-light text-dark">{{ $program['active_clients'] }}</span>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <span class="badge 
                                    @if($program['status'] == 'active') bg-success
                                    @else bg-secondary @endif">
                                    {{ ucfirst($program['status']) }}
                                </span>
                                <small class="text-muted ms-2">
                                    Created {{ \Carbon\Carbon::parse($program['created_at'])->diffForHumans() }}
                                </small>
                            </div>

                            <!-- Actions -->
                            <div class="d-grid gap-2">
                                <a href="{{ route('trainer.programs.show', $program['id']) }}" 
                                   class="btn trainer-btn-primary btn-sm">
                                    <i class="bi bi-eye me-1"></i>View Program
                                </a>
                                <div class="btn-group">
                                    <a href="{{ route('trainer.programs.edit', $program['id']) }}" 
                                       class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-files"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-share"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Empty State -->
        @if(count($programs) == 0)
            <div class="col-12">
                <div class="card trainer-card">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-journal-text text-muted" style="font-size: 4rem;"></i>
                        <h4 class="mt-3 mb-2">No Programs Created Yet</h4>
                        <p class="text-muted mb-4">Create your first training program to get started with client management.</p>
                        <a href="{{ route('trainer.programs.create') }}" class="btn trainer-btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Create Your First Program
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if(count($programs) > 0)
        <div class="col-12">
            <div class="card trainer-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Showing {{ count($programs) }} of {{ count($programs) }} programs</small>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Program</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this program? This action cannot be undone.</p>
                <p class="text-danger"><strong>Warning:</strong> Clients currently enrolled in this program will lose access.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Program</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function deleteProgram(programId) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = `/trainer/programs/${programId}`;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    // Search functionality
    document.querySelector('input[placeholder="Search programs..."]').addEventListener('input', function() {
        console.log('Searching for:', this.value);
        // Add search functionality here
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