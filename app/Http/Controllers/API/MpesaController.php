<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\MpesaTrait;

class MpesaController extends Controller
{
    use MpesaTrait {
        stkPushRequest as performStkPushRequest;
        stkPushCallback as performStkPushCallback;
    }

    // Generate Access Token
    public function token()
    {
        try {
            $accessToken = $this->generateAccessToken();

            return response()->json([
                'status'       => 'success',
                'access_token' => $accessToken,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // Register C2B Confirmation and Validation URLs
    public function registerClientUrl()
    {
        return response()->json($this->registerUrls());
    }

    // Initiate STK Push
    public function stkPushRequest(Request $request)
    {
        $data = $request->validate([
            'phone'             => 'required|string',
            'amount'            => 'required|numeric',
            'account_reference' => 'required|string',
            'description'       => 'required|string',
            'callback_url'      => 'nullable|url',
        ]);

        $response = $this->performStkPushRequest(
            $data['phone'],
            $data['amount'],
            $data['account_reference'],
            $data['description'],
            $data['callback_url'] ?? null
        );

        return response()->json($response);
    }

    // Query STK Push Status
    public function checkStkPushStatus(Request $request)
    {
        $data = $request->validate([
            'checkout_request_id' => 'required|string',
        ]);

        return response()->json($this->stkTransactionQuery($data['checkout_request_id']));
    }

    // STK Callback Receiver
    public function stkPushCallback(Request $request)
    {
        $result = $this->performStkPushCallback($request->all());
        return response()->json(['status' => 'received', 'data' => $result]);
    }

    // C2B Confirmation Receiver
    public function c2bConfirmation(Request $request)
    {
        return $this->c2bConfirmationCallback($request);
    }

    // C2B Validation Receiver
    public function validation(Request $request)
    {
        return $this->c2bValidationCallback($request);
    }

    // Verify Paid Amount
    public function amountBeingPaidIsValid(Request $request)
    {
        $data = $request->validate([
            'expected_amount' => 'required|numeric',
            'paid_amount'     => 'required|numeric',
        ]);

        $valid = $this->amountIsEqual($data['paid_amount'], $data['expected_amount']);

        return response()->json([
            'valid' => $valid,
            'message' => $valid ? 'Amount matches' : 'Amount does not match'
        ]);
    }
}
