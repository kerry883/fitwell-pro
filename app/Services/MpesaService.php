<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MpesaService
{
    protected $baseUrl;
    protected $appKey;
    protected $appSecret;
    protected $merchantId;
    protected $businessShortcode;
    protected $initiatorName;
    protected $environment;

    public function __construct()
    {
        $this->environment = config('mpesa.environment', 'sandbox');
        $this->baseUrl = $this->environment === 'sandbox' 
            ? config('mpesa.sandbox_baseurl') 
            : config('mpesa.live_baseurl');
        $this->appKey = config('mpesa.app_key');
        $this->appSecret = config('mpesa.app_secret');
        $this->merchantId = config('mpesa.merchant_id');
        $this->businessShortcode = config('mpesa.business_shortcode');
        $this->initiatorName = config('mpesa.initiator_name');
    }

    /**
     * Generate OAuth token for API authentication using Daraja 3.0
     */
    public function getAccessToken()
    {
        try {
            // Validate credentials
            if (empty($this->appKey) || empty($this->appSecret)) {
                Log::error('M-Pesa credentials missing', [
                    'app_key_set' => !empty($this->appKey),
                    'app_secret_set' => !empty($this->appSecret)
                ]);
                return null;
            }

            $credentials = base64_encode($this->appKey . ':' . $this->appSecret);
            $tokenUrl = $this->baseUrl . ($this->environment === 'sandbox' 
                ? config('mpesa.sandbox_token_url') 
                : config('mpesa.live_token_url'));

            Log::info('M-Pesa: Requesting access token', [
                'url' => $tokenUrl,
                'environment' => $this->environment
            ]);
            
            $response = Http::withOptions([
                'verify' => false, // Disable SSL verification for sandbox testing
            ])->withHeaders([
                'Authorization' => 'Basic ' . $credentials,
                'Content-Type' => 'application/json'
            ])->get($tokenUrl);

            Log::info('M-Pesa: Token response received', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            $result = json_decode($response->body());

            if (isset($result->access_token)) {
                Log::info('M-Pesa: Access token generated successfully');
                return $result->access_token;
            }

            Log::error('M-Pesa access token error', [
                'status' => $response->status(),
                'response' => $result,
                'body' => $response->body()
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('M-Pesa access token exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Initiate STK Push transaction using Daraja 2.0
     */
    public function initiateSTKPush($phoneNumber, $amount, $reference, $description)
    {
        try {
            $token = $this->getAccessToken();
            if (!$token) {
                return [
                    'success' => false,
                    'message' => 'Unable to generate access token'
                ];
            }

            // Format phone number (remove + and country code if present)
            $phoneNumber = preg_replace('/^\+?254/', '254', $phoneNumber);
            if (!preg_match('/^254\d{9}$/', $phoneNumber)) {
                return [
                    'success' => false,
                    'message' => 'Invalid phone number format. Use 254XXXXXXXXX'
                ];
            }

            // Format timestamp for Daraja 2.0
            $timestamp = Carbon::now()->format('YmdHis');
            
            // Generate password using Shortcode, Passkey and Timestamp
            $passkey = config('mpesa.passkey', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919');
            $password = base64_encode($this->businessShortcode . $passkey . $timestamp);

            Log::info('M-Pesa: Initiating STK Push', [
                'phone' => $phoneNumber,
                'amount' => ceil($amount),
                'reference' => $reference
            ]);

            $response = Http::withOptions([
                'verify' => false, // Disable SSL verification for sandbox
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post($this->baseUrl . ($this->environment === 'sandbox' 
                ? config('mpesa.sandbox_stkpush_url') 
                : config('mpesa.live_stkpush_url')), [
                'BusinessShortCode' => $this->businessShortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => ceil($amount),
                'PartyA' => $phoneNumber,
                'PartyB' => $this->businessShortcode,
                'PhoneNumber' => $phoneNumber,
                'CallBackURL' => route('mpesa.callback'),
                'AccountReference' => $reference,
                'TransactionDesc' => $description,
            ]);

            Log::info('M-Pesa: STK Push response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            $result = json_decode($response->body());

            if (isset($result->CheckoutRequestID)) {
                return [
                    'success' => true,
                    'CheckoutRequestID' => $result->CheckoutRequestID,
                    'ResponseCode' => $result->ResponseCode ?? '0',
                    'CustomerMessage' => $result->CustomerMessage ?? 'Request sent successfully',
                ];
            }

            Log::error('M-Pesa STK push error', [
                'status' => $response->status(),
                'response' => $result
            ]);
            return [
                'success' => false,
                'message' => 'Failed to initiate M-Pesa payment'
            ];

        } catch (\Exception $e) {
            Log::error('M-Pesa STK push exception', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'An error occurred while processing M-Pesa payment'
            ];
        }
    }

    /**
     * Query STK Push transaction status using Daraja 2.0
     */
    public function querySTKStatus($checkoutRequestId)
    {
        try {
            $token = $this->getAccessToken();
            if (!$token) {
                return [
                    'success' => false,
                    'message' => 'Unable to generate access token'
                ];
            }

            // Format timestamp
            $timestamp = Carbon::now()->format('YmdHis');
            
            // Generate password
            $passkey = config('mpesa.passkey', 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919');
            $password = base64_encode($this->businessShortcode . $passkey . $timestamp);

            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->post($this->baseUrl . ($this->environment === 'sandbox' 
                ? config('mpesa.sandbox_stkstatus_url') 
                : config('mpesa.live_stkstatus_url')), [
                'BusinessShortCode' => $this->businessShortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'CheckoutRequestID' => $checkoutRequestId,
            ]);

            return json_decode($response->body(), true);

        } catch (\Exception $e) {
            Log::error('M-Pesa query status error', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Failed to check payment status'
            ];
        }
    }
}