<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    protected array $config;
    protected string $baseUri;

    public function __construct()
    {
        $this->config  = config('mpesa');
        $this->baseUri = $this->config['env'] === 'production'
            ? 'https://api.safaricom.co.ke/'
            : 'https://sandbox.safaricom.co.ke/';
    }

    /**
     * Generate an OAuth access token
     */
    public function getAccessToken(): string
    {
        $response = Http::baseUrl($this->baseUri)
            ->withBasicAuth(
                $this->config['consumer_key'],
                $this->config['consumer_secret']
            )
            ->acceptJson()
            ->get('oauth/v1/generate', [
                'grant_type' => 'client_credentials',
            ]);

        if ($response->failed()) {
            Log::error('M-PESA Token Error', $response->json());
            throw new \Exception('Failed to get M-PESA access token');
        }

        return $response->json('access_token');
    }

    /**
     * Send an STK Push request
     */
    public function stkPush(
        float  $amount,
        string $phone,
        string $accountRef,
        string $description
    ): array {
        $token     = $this->getAccessToken();
        $timestamp = now()->format('YmdHis');
        $password  = base64_encode(
            $this->config['shortcode'] .
            $this->config['passkey'] .
            $timestamp
        );

        $payload = [
            'BusinessShortCode' => $this->config['shortcode'],
            'Password'          => $password,
            'Timestamp'         => $timestamp,
            'TransactionType'   => 'CustomerPayBillOnline',
            'Amount'            => $amount,
            'PartyA'            => $phone,
            'PartyB'            => $this->config['shortcode'],
            'PhoneNumber'       => $phone,
            'CallBackURL'       => $this->config['callback_url'],
            'AccountReference'  => $accountRef,
            'TransactionDesc'   => $description,
        ];

        $response = Http::baseUrl($this->baseUri)
            ->withToken($token)
            ->acceptJson()
            ->post('mpesa/stkpush/v1/processrequest', $payload);

        if ($response->failed()) {
            Log::error('M-PESA STK Push Error', $response->json());
        }

        return $response->json();
    }
}
