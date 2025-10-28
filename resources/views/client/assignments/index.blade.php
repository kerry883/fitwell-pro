@php
    $title = 'My Programs';
@endphp

@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">My Programs</h2>
        <p class="text-gray-600">Track your enrolled programs and progress</p>
    </div>

    <!-- Programs List -->
    <div class="space-y-4">
        @forelse($assignments as $assignment)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                <div class="p-4 sm:p-6">
                    <!-- Mobile Layout: Stack Everything -->
                    <div class="lg:flex lg:items-center lg:justify-between">
                        <!-- Left Side: Program Info -->
                        <div class="flex items-start space-x-4 flex-1 min-w-0">
                            <!-- Avatar -->
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-emerald-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-lg sm:text-xl">
                                        {{ substr($assignment->program->name, 0, 1) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Program Details -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 truncate">
                                        {{ $assignment->program->name }}
                                    </h3>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium whitespace-nowrap
                                        @if($assignment->status->value === 'active') bg-green-100 text-green-800
                                        @elseif($assignment->status->value === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($assignment->status->value === 'pending_payment') bg-blue-100 text-blue-800
                                        @elseif($assignment->status->value === 'completed') bg-purple-100 text-purple-800
                                        @elseif($assignment->status->value === 'withdrawn') bg-gray-100 text-gray-800
                                        @elseif($assignment->status->value === 'cancelled') bg-gray-200 text-gray-900
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $assignment->status->value)) }}
                                    </span>
                                </div>
                                
                                <p class="text-sm text-gray-600 mb-2">
                                    by {{ $assignment->program->trainer->user->full_name ?? 'Trainer' }}
                                </p>
                                
                                <!-- Payment deadline for pending_payment status -->
                                @if($assignment->status->value === 'pending_payment' && $assignment->payment_deadline)
                                    <div class="flex items-center text-xs sm:text-sm text-orange-600 mb-2 bg-orange-50 px-3 py-2 rounded-md">
                                        <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Payment due: {{ $assignment->payment_deadline->format('M j, Y \a\t g:i A') }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex flex-wrap gap-4 text-xs sm:text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>Week {{ $assignment->current_week }} of {{ $assignment->program->duration_weeks }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        <span>{{ $assignment->progress_percentage }}% Complete</span>
                                    </div>
                                </div>

                                <!-- Progress Bar (for active programs) -->
                                @if($assignment->status->value === 'active')
                                    <div class="mt-4">
                                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                                            <span>Progress</span>
                                            <span>{{ $assignment->progress_percentage }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-emerald-500 h-2.5 rounded-full transition-all duration-300" 
                                                 style="width: {{ $assignment->progress_percentage }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Right Side: Action Buttons -->
                        <div class="mt-4 lg:mt-0 lg:ml-6 flex flex-col sm:flex-row lg:flex-col xl:flex-row gap-2 lg:items-end">
                            <!-- Complete Payment Button (ONLY for pending_payment status AND paid programs) -->
                            @if($assignment->status->value === 'pending_payment')
                                @if(!$assignment->program->is_free)
                                    <!-- Show payment button for paid programs -->
                                    <a href="{{ route('client.payment.checkout', $assignment->id) }}"
                                       class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200 shadow-sm whitespace-nowrap">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                        Complete Payment
                                    </a>
                                    <!-- Cancel Payment & Withdraw Button -->
                                    <button type="button"
                                            onclick="openCancelPaymentModal({{ $assignment->id }}, '{{ addslashes($assignment->program->name) }}', {{ $assignment->program->price }})"
                                            class="inline-flex items-center justify-center px-4 py-2.5 border border-red-300 text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 whitespace-nowrap">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancel & Withdraw
                                    </button>
                                @else
                                    <!-- Free program stuck in pending_payment (shouldn't happen) -->
                                    <span class="inline-flex items-center px-4 py-2 border border-orange-300 text-sm font-medium rounded-lg text-orange-700 bg-orange-50 whitespace-nowrap">
                                        <svg class="w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Processing...
                                    </span>
                                @endif
                            
                            @elseif($assignment->status->value === 'active')
                                <!-- Start/Continue Program -->
                                <a href="{{ route('client.assignments.show', $assignment->id) }}"
                                   class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200 whitespace-nowrap">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Continue Program
                                </a>
                                <!-- Withdraw Button -->
                                @if($assignment->can_withdraw)
                                    <button type="button"
                                            onclick="openWithdrawModal({{ $assignment->id }}, '{{ addslashes($assignment->program->name) }}')"
                                            class="inline-flex items-center justify-center px-4 py-2.5 border border-yellow-400 text-sm font-medium rounded-lg text-yellow-700 bg-white hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200 whitespace-nowrap">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Withdraw
                                    </button>
                                @endif
                            
                            @elseif($assignment->status->value === 'pending')
                                <!-- Pending Approval Badge -->
                                <span class="inline-flex items-center px-4 py-2 border border-yellow-300 text-sm font-medium rounded-lg text-yellow-700 bg-yellow-50 whitespace-nowrap">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Waiting for Approval
                                </span>
                                <!-- Withdraw Button -->
                                @if($assignment->can_withdraw)
                                    <button type="button"
                                            onclick="openWithdrawModal({{ $assignment->id }}, '{{ addslashes($assignment->program->name) }}')"
                                            class="inline-flex items-center justify-center px-4 py-2.5 border border-yellow-400 text-sm font-medium rounded-lg text-yellow-700 bg-white hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200 whitespace-nowrap">
                                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Withdraw
                                    </button>
                                @endif
                            
                            @elseif($assignment->status->value === 'withdrawn' || $assignment->status->value === 'rejected' || $assignment->status->value === 'cancelled')
                                <!-- Delete Button for withdrawn/rejected/cancelled programs -->
                                <button type="button"
                                        onclick="openDeleteModal({{ $assignment->id }}, '{{ addslashes($assignment->program->name) }}')"
                                        class="inline-flex items-center justify-center px-4 py-2.5 border border-red-300 text-sm font-medium rounded-lg text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 whitespace-nowrap">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete
                                </button>
                            
                            @else
                                <!-- View Details (for other statuses) -->
                                <a href="{{ route('client.assignments.show', $assignment->id) }}"
                                   class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200 whitespace-nowrap">
                                    View Details
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-12">
                <div class="text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No enrolled programs</h3>
                    <p class="mt-2 text-gray-600">Browse available programs to get started.</p>
                    <div class="mt-6">
                        <a href="{{ route('programs.index') }}" 
                           class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Browse Programs
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Withdraw Modal -->
<div id="withdrawModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto z-50">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-5 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900">Withdraw from Program</h3>
                <button onclick="closeWithdrawModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                    <div class="flex">
                        <svg class="h-5 w-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-yellow-800">Warning!</p>
                            <p class="text-sm text-yellow-700 mt-1">This action cannot be undone.</p>
                        </div>
                    </div>
                </div>

                <p class="text-gray-700 mb-4">
                    Are you sure you want to withdraw from <strong id="withdrawProgramName" class="text-gray-900"></strong>?
                </p>

                <form id="withdrawForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="mb-4">
                        <label for="withdrawReason" class="block text-sm font-medium text-gray-700 mb-2">
                            Reason for withdrawal (optional)
                        </label>
                        <textarea id="withdrawReason" name="reason" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                  placeholder="Please let us know why you're withdrawing..."></textarea>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end space-x-3 px-6 py-4 bg-gray-50 rounded-b-lg">
                <button type="button" onclick="closeWithdrawModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                    Cancel
                </button>
                <button type="button" onclick="submitWithdraw()"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Withdraw
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Payment Modal -->
<div id="cancelPaymentModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto z-50">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-5 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900">Cancel Payment & Withdraw</h3>
                <button onclick="closeCancelPaymentModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-red-800">Important!</p>
                            <p class="text-sm text-red-700 mt-1">This will cancel your payment and withdraw you from the program.</p>
                        </div>
                    </div>
                </div>

                <p class="text-gray-700 mb-2">
                    Are you sure you want to cancel payment for <strong id="cancelProgramName" class="text-gray-900"></strong>?
                </p>
                <p class="text-sm text-gray-600 mb-4">
                    Amount: <strong id="cancelProgramPrice" class="text-gray-900"></strong>
                </p>

                <form id="cancelPaymentForm" method="POST" action="">
                    @csrf
                    <div class="mb-4">
                        <label for="cancelReason" class="block text-sm font-medium text-gray-700 mb-2">
                            Reason for cancellation (optional)
                        </label>
                        <textarea id="cancelReason" name="reason" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                                  placeholder="Please let us know why you're cancelling..."></textarea>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end space-x-3 px-6 py-4 bg-gray-50 rounded-b-lg">
                <button type="button" onclick="closeCancelPaymentModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                    Keep Program
                </button>
                <button type="button" onclick="submitCancelPayment()"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancel Payment
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Program Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-75 overflow-y-auto z-50">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-5 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900">Delete Program</h3>
                <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                    <div class="flex">
                        <svg class="h-5 w-5 text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm text-blue-700">This will permanently remove the program from your list.</p>
                        </div>
                    </div>
                </div>

                <p class="text-gray-700">
                    Are you sure you want to delete <strong id="deleteProgramName" class="text-gray-900"></strong> from your programs?
                </p>

                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end space-x-3 px-6 py-4 bg-gray-50 rounded-b-lg">
                <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                    Cancel
                </button>
                <button type="button" onclick="submitDelete()"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    <svg class="w-4 h-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Withdraw Modal Functions
function openWithdrawModal(assignmentId, programName) {
    document.getElementById('withdrawProgramName').textContent = programName;
    document.getElementById('withdrawForm').action = `/client/assignments/${assignmentId}/withdraw`;
    document.getElementById('withdrawReason').value = '';
    document.getElementById('withdrawModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeWithdrawModal() {
    document.getElementById('withdrawModal').classList.add('hidden');
    document.getElementById('withdrawReason').value = '';
    document.body.style.overflow = '';
}

function submitWithdraw() {
    document.getElementById('withdrawForm').submit();
}

// Cancel Payment Modal Functions
function openCancelPaymentModal(assignmentId, programName, programPrice) {
    document.getElementById('cancelProgramName').textContent = programName;
    document.getElementById('cancelProgramPrice').textContent = '$' + parseFloat(programPrice).toFixed(2);
    document.getElementById('cancelPaymentForm').action = `/client/assignments/${assignmentId}/cancel-payment`;
    document.getElementById('cancelReason').value = '';
    document.getElementById('cancelPaymentModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCancelPaymentModal() {
    document.getElementById('cancelPaymentModal').classList.add('hidden');
    document.getElementById('cancelReason').value = '';
    document.body.style.overflow = '';
}

function submitCancelPayment() {
    document.getElementById('cancelPaymentForm').submit();
}

// Delete Modal Functions
function openDeleteModal(assignmentId, programName) {
    document.getElementById('deleteProgramName').textContent = programName;
    document.getElementById('deleteForm').action = `/client/assignments/${assignmentId}`;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = '';
}

function submitDelete() {
    document.getElementById('deleteForm').submit();
}

// Close modals when clicking outside
document.getElementById('withdrawModal').addEventListener('click', function(e) {
    if (e.target === this) closeWithdrawModal();
});

document.getElementById('cancelPaymentModal').addEventListener('click', function(e) {
    if (e.target === this) closeCancelPaymentModal();
});

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});

// Close modals with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeWithdrawModal();
        closeCancelPaymentModal();
        closeDeleteModal();
    }
});
</script>
@endsection
