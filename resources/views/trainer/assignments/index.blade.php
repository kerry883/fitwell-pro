@extends('layouts.trainer')

@section('title', 'Pending Assignments')
@section('page-title', 'Pending Assignments')
@section('page-subtitle', 'Review and approve client enrollment requests for your programs')

@section('content')
<div class="container-fluid">
    <!-- Assignments List -->
    <div class="trainer-card">
        <div class="card-body p-0">
            <ul role="list" class="list-unstyled mb-0">
                @forelse($pendingAssignments as $assignment)
                    <li class="border-bottom p-4 transition-colors" data-assignment-id="{{ $assignment->id }}" style="transition-duration: 300ms;">
                        <div class="d-flex align-items-center justify-content-between">
                        <div class="flex items-center space-x-4">
                            <!-- Client Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-lg">
                                        {{ substr($assignment->client->user->full_name ?? 'C', 0, 1) }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center text-white fw-semibold" style="width: 48px; height: 48px;">
                                    <span>{{ substr($assignment->client->user->full_name ?? 'C', 0, 1) }}</span>
                                </div>
                            </div>

                            <!-- Assignment Details -->
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex align-items-center mb-1">
                                    <p class="mb-0 fw-semibold text-dark me-2">
                                        {{ $assignment->client->user->full_name ?? 'Unknown Client' }}
                                    </p>
                                    <span class="badge bg-warning text-dark">
                                        Pending Approval
                                    </span>
                                </div>
                                <p class="mb-1 text-muted small">
                                    Requested to enroll in: <span class="fw-medium">{{ $assignment->program->name }}</span>
                                </p>
                                <p class="mb-0 text-muted" style="font-size: 0.75rem;">
                                    Requested on {{ $assignment->assigned_date->format('M j, Y \a\t g:i A') }}
                                </p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex align-items-center gap-3">
                            <!-- Program Price Badge -->
                            @if($assignment->program->is_free)
                                <span class="badge bg-success-subtle text-success d-inline-flex align-items-center">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Free Program
                                </span>
                            @else
                                <span class="badge bg-info-subtle text-info d-inline-flex align-items-center">
                                    <i class="bi bi-currency-dollar me-1"></i>
                                    ${{ number_format($assignment->program->price, 2) }}
                                </span>
                            @endif

                            <!-- View Details Button -->
                            <a href="{{ route('trainer.clients.activate', ['id' => $assignment->client->user->id, 'assignment' => $assignment->id]) }}"
                               class="btn btn-sm trainer-btn-primary text-white">
                                <i class="bi bi-eye me-1"></i>
                                Review & Activate
                            </a>
                        </div>
                    </div>
                </li>
            @empty
                <li class="p-5 text-center">
                    <div class="py-4">
                        <i class="bi bi-file-earmark-text text-muted" style="font-size: 3rem;"></i>
                        <h5 class="mt-3 mb-2 fw-semibold">No pending assignments</h5>
                        <p class="text-muted mb-0">All enrollment requests have been processed.</p>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>
</div>
</div><!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Approve Enrollment Request</h3>
                <button onclick="closeApproveModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>


<script>
// Highlight assignment from notification
document.addEventListener('DOMContentLoaded', function() {
    // Get highlight parameter from URL
    const urlParams = new URLSearchParams(window.location.search);
    const highlightId = urlParams.get('highlight');
    
    if (highlightId) {
        // Find the assignment row
        const assignments = document.querySelectorAll('li[data-assignment-id]');
        assignments.forEach(li => {
            if (li.dataset.assignmentId === highlightId) {
                // Add highlight effect (Bootstrap classes)
                li.classList.add('bg-warning', 'bg-opacity-10', 'border', 'border-warning');
                li.style.transition = 'all 0.3s ease';
                
                // Scroll to the assignment
                setTimeout(() => {
                    li.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 100);
                
                // Remove highlight after 5 seconds
                setTimeout(() => {
                    li.classList.remove('bg-warning', 'bg-opacity-10', 'border', 'border-warning');
                }, 5000);
            }
        });
    }
});
</script>
@endsection
