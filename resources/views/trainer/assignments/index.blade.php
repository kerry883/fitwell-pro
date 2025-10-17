@php
    $title = 'Pending Assignments';
@endphp

@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Pending Assignments
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Review and approve client enrollment requests for your programs
            </p>
        </div>
    </div>

    <!-- Assignments List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul role="list" class="divide-y divide-gray-200">
            @forelse($pendingAssignments as $assignment)
                <li class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Client Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-emerald-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-lg">
                                        {{ substr($assignment->client->user->full_name ?? 'C', 0, 1) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Assignment Details -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $assignment->client->user->full_name ?? 'Unknown Client' }}
                                    </p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pending Approval
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500">
                                    Requested to enroll in: <span class="font-medium">{{ $assignment->program->name }}</span>
                                </p>
                                <p class="text-xs text-gray-400">
                                    Requested on {{ $assignment->assigned_date->format('M j, Y \a\t g:i A') }}
                                </p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center space-x-3">
                            <!-- Approve Button -->
                            <form method="POST" action="{{ route('trainer.assignments.approve', $assignment->id) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200">
                                    <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Approve
                                </button>
                            </form>

                            <!-- Reject Button -->
                            <button type="button"
                                    onclick="openRejectModal({{ $assignment->id }}, '{{ $assignment->client->user->full_name ?? 'Unknown Client' }}', '{{ $assignment->program->name }}')"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200">
                                <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Reject
                            </button>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-6 py-12">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No pending assignments</h3>
                        <p class="mt-1 text-sm text-gray-500">All enrollment requests have been processed.</p>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Reject Enrollment Request</h3>
                <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-600">
                    Are you sure you want to reject <span id="clientName" class="font-medium"></span>'s enrollment request for <span id="programName" class="font-medium"></span>?
                </p>
            </div>

            <form id="rejectForm" method="POST" action="">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason for rejection (optional)
                    </label>
                    <textarea id="reason" name="reason" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500"
                              placeholder="Provide a reason for the rejection..."></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Reject Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openRejectModal(assignmentId, clientName, programName) {
    document.getElementById('clientName').textContent = clientName;
    document.getElementById('programName').textContent = programName;
    document.getElementById('rejectForm').action = `/trainer/assignments/${assignmentId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('reason').value = '';
}

// Close modal when clicking outside
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeRejectModal();
    }
});
</script>
@endsection
