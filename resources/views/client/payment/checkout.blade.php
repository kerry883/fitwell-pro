@extends('layouts.app')

@section('title', 'Payment Checkout')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Complete Your Payment</h1>
        <p class="text-gray-600">Secure payment processing powered by Stripe</p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <!-- Order Summary -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Program</p>
                        <p class="font-medium text-gray-900">{{ $program->name }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">Duration</p>
                        <p class="font-medium text-gray-900">{{ $program->duration_weeks }} weeks</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">Category</p>
                        <p class="font-medium text-gray-900">{{ ucfirst($program->program_category->value) }}</p>
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

                <div class="border-t border-gray-200 mt-6 pt-6">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-gray-900">Total</span>
                        <span class="text-2xl font-bold text-emerald-600">${{ number_format($amount, 2) }}</span>
                    </div>
                </div>

                <div class="mt-6 p-3 bg-green-50 border border-green-200 rounded-md">
                    <p class="text-xs text-green-800 font-medium">🔒 Secure Payment</p>
                    <p class="text-xs text-green-700 mt-1">
                        Your payment is secured by Stripe. We never store your card details.
                    </p>
                </div>

                @if($program->refund_policy_days)
                <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
                    <p class="text-xs text-blue-800 font-medium">💰 Money-Back Guarantee</p>
                    <p class="text-xs text-blue-700 mt-1">
                        {{ $program->refund_policy_days }}-day refund policy applies
                    </p>
                </div>
                @endif
            </div>
        </div>

        <!-- Payment Form -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Payment Details</h2>

                <form id="payment-form">
                    @csrf
                    
                    <!-- Stripe Card Element -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Card Information
                        </label>
                        <div id="card-element" class="p-3 border border-gray-300 rounded-md bg-white">
                            <!-- Stripe.js will inject the Card Element here -->
                        </div>
                        <div id="card-errors" class="mt-2 text-sm text-red-600"></div>
                    </div>

                    <!-- Cardholder Name -->
                    <div class="mb-6">
                        <label for="cardholder-name" class="block text-sm font-medium text-gray-700 mb-2">
                            Cardholder Name
                        </label>
                        <input type="text" 
                               id="cardholder-name" 
                               name="name" 
                               value="{{ auth()->user()->full_name }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                               required>
                    </div>

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ auth()->user()->email }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                               required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            id="submit-button"
                            class="w-full bg-emerald-600 text-white py-3 px-4 rounded-md font-semibold hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                        <span id="button-text">Pay ${{ number_format($amount, 2) }}</span>
                        <span id="spinner" class="hidden">
                            <svg class="animate-spin inline-block w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>

                    <p class="mt-4 text-xs text-center text-gray-500">
                        By completing this payment, you agree to the program terms and conditions.
                    </p>
                </form>

                <!-- Cancel Link -->
                <div class="mt-6 text-center">
                    <a href="{{ route('client.assignments.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        ← Cancel and return to dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    // Initialize Stripe
    const stripe = Stripe('{{ config('services.stripe.key') }}');
    const elements = stripe.elements();
    
    // Create card element
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#dc2626',
                iconColor: '#dc2626'
            }
        }
    });
    
    cardElement.mount('#card-element');
    
    // Handle real-time validation errors
    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    
    // Handle form submission
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const buttonText = document.getElementById('button-text');
    const spinner = document.getElementById('spinner');
    
    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        
        // Disable button and show spinner
        submitButton.disabled = true;
        buttonText.classList.add('hidden');
        spinner.classList.remove('hidden');
        
        try {
            const {error, paymentIntent} = await stripe.confirmCardPayment('{{ $clientSecret }}', {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: document.getElementById('cardholder-name').value,
                        email: document.getElementById('email').value
                    }
                }
            });
            
            if (error) {
                // Show error to customer
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
                
                // Re-enable button
                submitButton.disabled = false;
                buttonText.classList.remove('hidden');
                spinner.classList.add('hidden');
            } else {
                // Payment succeeded - redirect to success page
                if (paymentIntent.status === 'succeeded') {
                    window.location.href = '{{ route('client.payment.success', $assignment->id) }}';
                }
            }
        } catch (err) {
            console.error('Payment error:', err);
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = 'An unexpected error occurred. Please try again.';
            
            // Re-enable button
            submitButton.disabled = false;
            buttonText.classList.remove('hidden');
            spinner.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection
