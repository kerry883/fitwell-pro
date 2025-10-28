@extends('layouts.app')

@section('title', 'Payment Successful')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        <!-- Success Icon -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                <svg class="w-12 h-12 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Successful!</h1>
            <p class="text-gray-600">Your program has been activated</p>
        </div>

        <!-- Program Details Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Program Details</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Program</span>
                    <span class="font-medium text-gray-900">{{ $program->name }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Category</span>
                    <span class="font-medium text-gray-900">{{ ucfirst($program->program_category->value) }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Duration</span>
                    <span class="font-medium text-gray-900">{{ $program->duration_weeks }} weeks</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600">Start Date</span>
                    <span class="font-medium text-gray-900">{{ $assignment->start_date ? $assignment->start_date->format('M j, Y') : 'Today' }}</span>
                </div>
                
                @if($assignment->end_date)
                <div class="flex justify-between">
                    <span class="text-gray-600">End Date</span>
                    <span class="font-medium text-gray-900">{{ $assignment->end_date->format('M j, Y') }}</span>
                </div>
                @endif
            </div>

            <div class="border-t border-gray-200 mt-4 pt-4">
                <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-gray-900">Amount Paid</span>
                    <span class="text-2xl font-bold text-green-600">${{ number_format($program->price, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- What's Next -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">What's Next?</h3>
            <ul class="space-y-2 text-sm text-blue-800">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>You'll receive a confirmation email shortly</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Access your program from your dashboard</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Your trainer will be notified and may reach out</span>
                </li>
                @if($program->refund_policy_days)
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $program->refund_policy_days }}-day money-back guarantee available</span>
                </li>
                @endif
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <a href="{{ route('client.assignments.show', $assignment->id) }}" 
               class="block w-full bg-emerald-600 text-white text-center py-3 px-4 rounded-md font-semibold hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                View My Program
            </a>
            
            <a href="{{ route('dashboard') }}" 
               class="block w-full bg-white text-gray-700 text-center py-3 px-4 rounded-md font-medium border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                Return to Dashboard
            </a>
        </div>

        <!-- Receipt Link -->
        <div class="mt-6 text-center">
            <a href="{{ route('client.payment.history') }}" class="text-sm text-gray-600 hover:text-gray-900">
                View payment history and receipt →
            </a>
        </div>
    </div>
</div>
@endsection
