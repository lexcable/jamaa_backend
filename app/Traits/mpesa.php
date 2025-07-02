<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait Mpesa
{
    public function __construct()
    {
        $this->mpesa_base_uri = 'https://sandbox.safaricom.co.ke/';
        // Ensure required config values are set
        if (!config('mpesa.consumer_key') || !config('mpesa.consumer_secret')) {
            throw new \Exception('M-PESA credentials not set in config/mpesa.php');
        }
    }
    /**
     * Get raw Daraja OAuth response
     */
    public function getToken()
    {
        try{
        $response = (
                    config('mpesa.consumer_key'),
                    config('mpesa.consumer_secret')
                )->get( $this->mpesa_base_uri . '?grant_type=client_credentials');

                log::info($response);
                return $response->json();
        } catch (\Exception $e) {
        log::info($e);
        }

    }

    /**
     * Returns access_token string
     */
    public function getAccessToken(): string
    {
        $data = $this->getToken();
        dump($data);
        return $data['access_token'] ??
               throw new \Exception('Access token not found in response');
    }

    /**
     * Initiate an STK Push
     *
     * @param string $phone      in 2547XXXXXXXX format
     * @param float  $amount
     * @param string $accountRef
     * @param string $description
     * @return array             decoded JSON response
     */
    public function stkPush(string $phone, float $amount, string $accountRef, string $description): array
    {
        $token     = $this->getAccessToken();
        dump('Token: ' . $token);
        $timestamp = now()->format('YmdHis');
        $password  = base64_encode(config('mpesa.shortcode') . config('mpesa.passkey') . $timestamp);

        $payload = [
            'BusinessShortCode' => config('mpesa.shortcode'),
            'Password'          => $password,
            'Timestamp'         => $timestamp,
            'TransactionType'   => 'CustomerPayBillOnline',
            'Amount'            => $amount,
            'PartyA'            => $phone,
            'PartyB'            => config('mpesa.shortcode'),
            'PhoneNumber'       => $phone,
            'CallBackURL'       => ('mpesa.stk.callback'),
            'AccountReference'  => $accountRef,
            'TransactionDesc'   => $description,
        ];
        dump($payload);
        $resp = Http::withToken($token)
                    ->post(config('mpesa.stk_push_endpoint'), $payload);

        if ($resp->failed()) {
            throw new \Exception('STK Push failed: ' . $resp->body());
        }

        return $resp->json();
    }

    /**
     * Register C2B Confirmation & Validation URLs
     *
     * @return array
     */
    public function registerUrls(): array
    {
        $token   = $this->getAccessToken();
        $payload = [
            'ShortCode'       => config('mpesa.shortcode'),
            'ResponseType'    => 'Completed',
            'ConfirmationURL' => route('mpesa.c2b.confirm'),
            'ValidationURL'   => route('mpesa.c2b.validate'),
        ];

        $resp = Http::withToken($token)
                    ->post(config('mpesa.c2b_register_endpoint'), $payload);

        if ($resp->failed()) {
            throw new \Exception('C2B URL registration failed: ' . $resp->body());
        }

        return $resp->json();
    }

    /**
     * Handle STK Push Callback (to be called from controller)
     */
    public function handleStkCallback(array $payload): array
    {
        Log::info('STK Callback', $payload);

        $cb = data_get($payload, 'Body.stkCallback');
        if (empty($cb)) {
            return ['ResultCode' => 1, 'ResultDesc' => 'Invalid STK callback payload'];
        }

        // return parsed callback for controller to process
        return $cb;
    }

    /**
     * Handle C2B Confirmation (called from controller)
     */
    public function handleC2bConfirmation(array $payload): array
    {
        Log::info('C2B Confirmation', $payload);
        return ['ResultCode' => 0, 'ResultDesc' => 'Accepted'];
    }

    /**
     * Handle C2B Validation (called from controller)
     */
    public function handleC2bValidation(array $payload): array
    {
        Log::info('C2B Validation', $payload);
        return ['ResultCode' => 0, 'ResultDesc' => 'Validated'];
    }
}
