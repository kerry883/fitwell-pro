@extends('layouts.app')

@section('title', 'Payment Failed')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        <!-- Error Icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 rounded-full mb-4">
                <svg class="w-12 h-12 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Failed</h1>
            <p class="text-gray-600">We couldn't process your payment</p>
        </div>

        <!-- Error Details Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Payment Error</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>{{ $error ?? 'Your payment could not be processed. Please try again.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="text-lg font-semibold text-gray-900 mb-4">Program Details</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Program</span>
                    <span class="font-medium text-gray-900">{{ $program->name }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Amount</span>
                    <span class="font-medium text-gray-900">${{ number_format($program->price, 2) }}</span>
                </div>

                @if($assignment->payment_deadline)
                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                    <p class="text-xs text-yellow-800 font-medium">⏰ Payment Deadline</p>
                    <p class="text-sm text-yellow-900 mt-1">
                        {{ $assignment->payment_deadline->format('M j, Y g:i A') }}
                    </p>
                    <p class="text-xs text-yellow-700 mt-1">
                        ({{ $assignment->payment_deadline->diffForHumans() }})
                    </p>
                </div>
                @endif
            </div>
        </div>

        <!-- Common Issues -->
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Common Issues</h3>
            <ul class="space-y-2 text-sm text-gray-700">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-gray-500 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Insufficient funds in your account</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-gray-500 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Incorrect card details entered</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-gray-500 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Card expired or blocked by your bank</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-gray-500 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Payment limit exceeded</span>
                </li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <a href="{{ route('client.payment.checkout', $assignment->id) }}" 
               class="block w-full bg-emerald-600 text-white text-center py-3 px-4 rounded-md font-semibold hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                Try Again
            </a>
            
            <a href="{{ route('client.assignments.index') }}" 
               class="block w-full bg-white text-gray-700 text-center py-3 px-4 rounded-md font-medium border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                Return to Dashboard
            </a>
        </div>

        <!-- Support Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Need help? <a href="mailto:support@fitwellpro.com" class="text-emerald-600 hover:text-emerald-700 font-medium">Contact Support</a>
            </p>
        </div>
    </div>
</div>
@endsection
