@extends('layouts.app')

@section('title', 'Request Refund')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Request Refund</h1>
        <p class="text-gray-600">Submit a refund request for your payment</p>
    </div>

    <!-- Payment Details Card -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment Details</h2>
        
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-600">Program</span>
                <span class="font-medium text-gray-900">{{ $payment->program->name }}</span>
            </div>
            
            <div class="flex justify-between">
                <span class="text-gray-600">Payment Date</span>
                <span class="font-medium text-gray-900">{{ $payment->paid_at ? $payment->paid_at->format('M j, Y') : $payment->created_at->format('M j, Y') }}</span>
            </div>
            
            <div class="flex justify-between">
                <span class="text-gray-600">Amount Paid</span>
                <span class="font-medium text-gray-900">${{ number_format($payment->amount, 2) }}</span>
            </div>
        </div>

        <div class="border-t border-gray-200 mt-4 pt-4">
            <div class="flex justify-between items-center">
                <span class="text-lg font-semibold text-gray-900">Refund Amount</span>
                <span class="text-2xl font-bold text-emerald-600">${{ number_format($payment->amount, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Refund Policy -->
    @if($payment->program->refund_policy_days)
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-3">Refund Policy</h3>
        <p class="text-sm text-blue-800 mb-3">
            This program offers a {{ $payment->program->refund_policy_days }}-day money-back guarantee.
        </p>
        @if($payment->canRefund())
            @php
                $refundDeadline = $payment->paid_at->addDays($payment->program->refund_policy_days);
            @endphp
            <p class="text-sm text-blue-800">
                <strong>Refund deadline:</strong> {{ $refundDeadline->format('M j, Y g:i A') }} 
                ({{ $refundDeadline->diffForHumans() }})
            </p>
        @endif
    </div>
    @endif

    <!-- Refund Form -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="POST" action="{{ route('client.payment.process-refund', $payment->id) }}">
            @csrf
            
            <div class="mb-6">
                <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                    Reason for Refund <span class="text-red-500">*</span>
                </label>
                <textarea id="reason" 
                          name="reason" 
                          rows="5" 
                          required
                          maxlength="500"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('reason') border-red-500 @enderror"
                          placeholder="Please provide a detailed reason for requesting a refund...">{{ old('reason') }}</textarea>
                
                @error('reason')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @else
                    <p class="mt-2 text-xs text-gray-500">Maximum 500 characters</p>
                @enderror
            </div>

            <!-- Terms Agreement -->
            <div class="mb-6">
                <label class="flex items-start">
                    <input type="checkbox" 
                           name="agree_terms" 
                           required
                           class="mt-1 h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                    <span class="ml-2 text-sm text-gray-700">
                        I understand that requesting a refund will immediately cancel my program access and this action cannot be undone.
                    </span>
                </label>
            </div>

            <!-- Warning Box -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Important Notice</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <ul class="list-disc pl-5 space-y-1">
                                <li>Refund processing may take 5-10 business days</li>
                                <li>Your program access will be revoked immediately</li>
                                <li>All progress data will be retained for your records</li>
                                <li>Refund requests are reviewed on a case-by-case basis</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex space-x-3">
                <button type="submit"
                        class="flex-1 bg-red-600 text-white py-3 px-4 rounded-md font-semibold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    Submit Refund Request
                </button>
                
                <a href="{{ route('client.payment.history') }}"
                   class="flex-1 bg-white text-gray-700 text-center py-3 px-4 rounded-md font-medium border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Support Link -->
    <div class="text-center">
        <p class="text-sm text-gray-600">
            Have questions about our refund policy? <a href="mailto:support@fitwellpro.com" class="text-emerald-600 hover:text-emerald-700 font-medium">Contact Support</a>
        </p>
    </div>
</div>
@endsection
