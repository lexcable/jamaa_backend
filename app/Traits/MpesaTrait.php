<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait MpesaTrait
{
    public function getToken()
    {
        $credentials = base64_encode(env('MPESA_CONSUMER_KEY') . ':' . env('MPESA_CONSUMER_SECRET'));
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials,
        ])->get($url);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        throw new \Exception('Failed to generate access token: ' . $response->body());
    }

    public function generateAccessToken()
    {
        return $this->getToken();
    }

    // ✅ PHONE NORMALIZER
    public function normalizePhoneNumber($phone)
    {
        $phone = preg_replace('/\D/', '', $phone); // Remove non-numeric characters

        if (substr($phone, 0, 1) === '0') {
            $phone = '254' . substr($phone, 1);
        }

        if (substr($phone, 0, 3) !== '254') {
            throw new \Exception('Invalid phone number format. Must start with 0 or 254');
        }

        return $phone;
    }

    public function stkPushRequest($phone, $amount, $accountReference, $transactionDesc)
    {
        $phone = $this->normalizePhoneNumber($phone); // Normalize phone before use

        $url = env('MPESA_BASE_URL') . '/mpesa/stkpush/v1/processrequest';
        $accessToken = $this->getToken();

        $timestamp = now()->format('YmdHis');
        $password = base64_encode(env('MPESA_SHORTCODE') . env('MPESA_PASSKEY') . $timestamp);

        $payload = [
            'BusinessShortCode' => env('MPESA_SHORTCODE'),
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone,
            'PartyB' => env('MPESA_SHORTCODE'),
            'PhoneNumber' => $phone,
            'CallBackURL' => env('MPESA_CALLBACK_URL'),
            'AccountReference' => $accountReference,
            'TransactionDesc' => $transactionDesc,
        ];

        $response = Http::withToken($accessToken)->post($url, $payload);

        Log::info('STK Push Request Sent:', $payload);
        Log::info('STK Push Response:', $response->json());

        return $response->json();
    }

    public function stkPushCallback($data)
    {
        Log::info('STK Callback Received:', $data);

        $resultCode = $data['Body']['stkCallback']['ResultCode'];
        $resultDesc = $data['Body']['stkCallback']['ResultDesc'];

        $amount = null;
        $mpesaReceiptNumber = null;
        $phoneNumber = null;

        if ($resultCode == 0) {
            $metadataItems = $data['Body']['stkCallback']['CallbackMetadata']['Item'];
            foreach ($metadataItems as $item) {
                if ($item['Name'] === 'Amount') {
                    $amount = $item['Value'];
                }
                if ($item['Name'] === 'MpesaReceiptNumber') {
                    $mpesaReceiptNumber = $item['Value'];
                }
                if ($item['Name'] === 'PhoneNumber') {
                    $phoneNumber = $item['Value'];
                }
            }
        }

        return [
            'success' => $resultCode == 0,
            'description' => $resultDesc,
            'amount' => $amount,
            'receipt' => $mpesaReceiptNumber,
            'phone' => $phoneNumber,
        ];
    }

    public function stkTransactionQuery($checkoutRequestID)
    {
        $url = env('MPESA_BASE_URL') . '/mpesa/stkpushquery/v1/query';
        $accessToken = $this->getToken();
        $timestamp = now()->format('YmdHis');
        $password = base64_encode(env('MPESA_SHORTCODE') . env('MPESA_PASSKEY') . $timestamp);

        $payload = [
            'BusinessShortCode' => env('MPESA_SHORTCODE'),
            'Password' => $password,
            'Timestamp' => $timestamp,
            'CheckoutRequestID' => $checkoutRequestID,
        ];

        $response = Http::withToken($accessToken)->post($url, $payload);

        Log::info('STK Transaction Query Payload:', $payload);
        Log::info('STK Query Response:', $response->json());

        return $response->json();
    }

    public function registerUrls()
    {
        $url = env('MPESA_BASE_URL') . '/mpesa/c2b/v1/registerurl';
        $accessToken = $this->getToken();

        $payload = [
            'ShortCode' => env('MPESA_C2B_SHORTCODE'),
            'ResponseType' => 'Completed',
            'ConfirmationURL' => env('MPESA_CONFIRMATION_URL'),
            'ValidationURL' => env('MPESA_VALIDATION_URL'),
        ];

        $response = Http::withToken($accessToken)->post($url, $payload);

        Log::info('Register URLs Payload:', $payload);
        Log::info('Register URLs Response:', $response->json());

        return $response->json();
    }

    public function c2bValidationCallback($request)
    {
        Log::info('C2B Validation Callback Received:', $request->all());

        return response()->json([
            'ResultCode' => 0,
            'ResultDesc' => 'Validation passed successfully'
        ]);
    }

    public function c2bConfirmationCallback($request)
    {
        Log::info('C2B Confirmation Callback Received:', $request->all());

        // Save to database if required

        return response()->json([
            'ResultCode' => 0,
            'ResultDesc' => 'Confirmation received successfully'
        ]);
    }

    public function amountIsEqual($amountPaid, $expectedAmount)
    {
        return floatval($amountPaid) === floatval($expectedAmount);
    }
}
