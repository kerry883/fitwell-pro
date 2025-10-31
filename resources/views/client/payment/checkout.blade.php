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
                        <span class="text-2xl font-bold text-emerald-600">{{ $program->getFormattedPrice() }}</span>
                    </div>
                    @if($program->currency === 'KES')
                    <div class="text-right mt-1">
                        <span class="text-xs text-gray-500">≈ ${{ number_format($program->getPriceInUSD(), 2) }} USD</span>
                    </div>
                    @endif
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

                <!-- Payment Method Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Select Payment Method</label>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-emerald-500 transition-colors" id="card-method">
                            <input type="radio" name="payment_method" value="card" class="text-emerald-600 focus:ring-emerald-500" checked>
                            <span class="ml-3">
                                <span class="block text-sm font-medium text-gray-900">Credit/Debit Card</span>
                                <span class="block text-xs text-gray-500">Pay securely with your card</span>
                            </span>
                            <img src="https://www.fitwell.pro/images/payments/cards.png" alt="Credit Cards" class="h-6 ml-auto">
                        </label>

                        <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-emerald-500 transition-colors" id="mpesa-method">
                            <input type="radio" name="payment_method" value="mpesa" class="text-emerald-600 focus:ring-emerald-500">
                            <span class="ml-3">
                                <span class="block text-sm font-medium text-gray-900">M-Pesa</span>
                                <span class="block text-xs text-gray-500">Pay with M-Pesa mobile money</span>
                            </span>
                            <img src="{{ asset('images/payments/mpesa.png') }}" alt="M-Pesa" class="h-6 ml-auto">
                        </label>
                    </div>
                </div>

                <!-- Card Payment Form -->
                <form id="card-payment-form" class="payment-form">
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
                            id="card-submit-button"
                            class="w-full bg-emerald-600 text-white py-3 px-4 rounded-md font-semibold hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                        <span class="button-text">Pay {{ $program->getFormattedPrice() }}</span>
                        <span class="spinner hidden">
                            <svg class="animate-spin inline-block w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </form>

                <!-- M-Pesa Payment Form -->
                <form id="mpesa-payment-form" class="payment-form hidden">
                    @csrf
                    
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <label class="block text-sm font-medium text-gray-700">Amount (KES)</label>
                        </div>
                        <div class="p-3 border border-gray-300 rounded-md bg-gray-50">
                            <span class="text-lg font-semibold text-gray-900">{{ $program->getFormattedPrice() }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">M-Pesa payments are processed in Kenyan Shillings</p>
                    </div>

                    <div class="mb-6">
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                            M-Pesa Phone Number
                        </label>
                        <input type="tel" 
                               id="phone_number" 
                               name="phone_number" 
                               placeholder="254712345678"
                               pattern="254[0-9]{9}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                               required>
                        <p class="mt-1 text-xs text-gray-500">Format: 254XXXXXXXXX (Safaricom number)</p>
                        <div id="mpesa-errors" class="mt-2 text-sm text-red-600"></div>
                    </div>

                    <button type="submit" 
                            id="mpesa-submit-button"
                            class="w-full bg-emerald-600 text-white py-3 px-4 rounded-md font-semibold hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                        <span class="button-text">Pay with M-Pesa</span>
                        <span class="spinner hidden">
                            <svg class="animate-spin inline-block w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>

                    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-md">
                        <h3 class="text-sm font-medium text-blue-800 mb-2">How to Pay:</h3>
                        <ol class="text-xs text-blue-700 list-decimal list-inside space-y-1">
                            <li>Enter your M-Pesa number above</li>
                            <li>Click "Pay with M-Pesa"</li>
                            <li>Wait for the STK Push prompt on your phone</li>
                            <li>Enter your M-Pesa PIN to complete payment</li>
                        </ol>
                    </div>
                </form>

                <p class="mt-4 text-xs text-center text-gray-500">
                    By completing this payment, you agree to the program terms and conditions.
                </p>

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

    // Payment method selection handling
    const cardMethod = document.getElementById('card-method');
    const mpesaMethod = document.getElementById('mpesa-method');
    const cardForm = document.getElementById('card-payment-form');
    const mpesaForm = document.getElementById('mpesa-payment-form');

    function showPaymentForm(method) {
        if (method === 'card') {
            cardForm.classList.remove('hidden');
            mpesaForm.classList.add('hidden');
        } else {
            cardForm.classList.add('hidden');
            mpesaForm.classList.remove('hidden');
        }
    }

    document.querySelectorAll('input[name="payment_method"]').forEach(input => {
        input.addEventListener('change', (e) => {
            showPaymentForm(e.target.value);
        });
    });

    // Handle card payment form submission
    const cardPaymentForm = document.getElementById('card-payment-form');
    const cardSubmitButton = document.getElementById('card-submit-button');
    const cardButtonText = cardSubmitButton.querySelector('.button-text');
    const cardSpinner = cardSubmitButton.querySelector('.spinner');
    
    // Handle card payment form submission
    cardPaymentForm.addEventListener('submit', async function(event) {
        event.preventDefault();
        cardSubmitButton.disabled = true;
        cardButtonText.classList.add('hidden');
        cardSpinner.classList.remove('hidden');
        
        // Confirm the payment on the client side using the client secret
        const { error, paymentIntent } = await stripe.confirmCardPayment('{{ $clientSecret }}', {
            payment_method: {
                card: cardElement,
                billing_details: {
                    name: document.getElementById('cardholder-name').value,
                    email: document.getElementById('email').value
                }
            }
        });
        
        if (error) {
            console.error('Payment error:', error);
            cardSubmitButton.disabled = false;
            cardButtonText.classList.remove('hidden');
            cardSpinner.classList.add('hidden');
            
            const errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
            return;
        }
        
        // Payment succeeded
        if (paymentIntent && paymentIntent.status === 'succeeded') {
            console.log('Payment succeeded:', paymentIntent);
            // Redirect to success page
            window.location.href = '{{ route('client.payment.success', $assignment->id) }}';
        }
    });

    // Handle M-Pesa payment form submission
    const mpesaPaymentForm = document.getElementById('mpesa-payment-form');
    const mpesaSubmitButton = document.getElementById('mpesa-submit-button');
    const mpesaButtonText = mpesaSubmitButton.querySelector('.button-text');
    const mpesaSpinner = mpesaSubmitButton.querySelector('.spinner');

    mpesaPaymentForm.addEventListener('submit', async function(event) {
        event.preventDefault();
        mpesaSubmitButton.disabled = true;
        mpesaButtonText.classList.add('hidden');
        mpesaSpinner.classList.remove('hidden');

        const phoneNumber = document.getElementById('phone_number').value;
        const errorElement = document.getElementById('mpesa-errors');

        try {
            const response = await fetch('{{ route('client.payment.mpesa.initiate', $assignment->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    phone_number: phoneNumber
                })
            });

            const result = await response.json();

            if (result.success) {
                // Show waiting message
                errorElement.textContent = '';
                mpesaButtonText.textContent = 'Check your phone...';
                mpesaButtonText.classList.remove('hidden');
                mpesaSpinner.classList.add('hidden');
                
                // Start polling for payment status
                const checkStatus = async () => {
                    try {
                        const statusResponse = await fetch('{{ route('client.payment.mpesa.status', $assignment->id) }}');
                        const statusResult = await statusResponse.json();

                        if (statusResult.success) {
                            if (statusResult.data.status === 'completed') {
                                window.location.href = '{{ route('client.payment.success', $assignment->id) }}';
                                return;
                            }
                        }

                        // Continue polling if payment is still pending
                        setTimeout(checkStatus, 5000);
                    } catch (error) {
                        console.error('Status check error:', error);
                    }
                };

                // Start checking status after 10 seconds
                setTimeout(checkStatus, 10000);
            } else {
                errorElement.textContent = result.message || 'Failed to initiate payment. Please try again.';
                mpesaSubmitButton.disabled = false;
                mpesaButtonText.classList.remove('hidden');
                mpesaSpinner.classList.add('hidden');
                mpesaButtonText.textContent = 'Pay with M-Pesa';
            }
        } catch (err) {
            console.error('M-Pesa payment error:', err);
            errorElement.textContent = 'An unexpected error occurred. Please try again.';
            
            mpesaSubmitButton.disabled = false;
            mpesaButtonText.classList.remove('hidden');
            mpesaSpinner.classList.add('hidden');
            mpesaButtonText.textContent = 'Pay with M-Pesa';
        }
    });
</script>
@endpush
@endsection
