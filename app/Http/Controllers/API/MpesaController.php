<?php

namespace App\Http\Controllers\API;

use App\Traits\Mpesa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MpesaController extends Controller
{
    use Mpesa;

    public function initiateStkPush(Request $request)
{
    dump('test 1');
    $validated = $request->validate([
        'phone' => 'required|string',
    ]);

    $phone = preg_replace('/\s+/', '', $validated['phone']); // Remove spaces
    $phone = ltrim($phone, '+');
    dump('test 2');
    if (preg_match('/^0/', $phone)) {
        $phone = '254' . substr($phone, 1);
    }


    dump('test 3');
    if (!preg_match('/^2547\d{8}$/', $phone)) {
        return response()->json([
            'error' => 'Invalid phone number format. Must start with 07 or 2547.'
        ], 422);
    }

    // Now call with 4 arguments
    $response = $this->stkPush(
        $phone,
        1, // amount
        'TestRef', // account reference
        'Payment description' // description
    );

    return response()->json($response);
}


    public function stkCallback(Request $request)
    {
        $cb = $this->handleStkCallback($request->all());
        // Process $cb...
    }

    public function registerUrls()
    {
        $resp = $this->registerUrls();
        return response()->json($resp);
    }

    public function confirm(Request $request)
    {
        $resp = $this->handleC2bConfirmation($request->all());
        return response()->json($resp);
    }

    public function validateTransaction(Request $request)
    {
        $resp = $this->handleC2bValidation($request->all());
        return response()->json($resp);
    }

    public function payOrder(Request $request, $id)
{
    $validated = $request->validate([
        'phone' => 'required|string',
    ]);
    dump('test 4');
    $phone = preg_replace('/\s+/', '', $validated['phone']);
    $phone = ltrim($phone, '+');

    dump('test 5');
    if (preg_match('/^0/', $phone)) {
        $phone = '254' . substr($phone, 1);
    }

    dump('test 6');
    if (!preg_match('/^2547\d{8}$/', $phone)) {
        return response()->json([
            'error' => 'Invalid phone number format. Must start with 07 or 2547.'
        ], 422);
    }

    // Now pass all 4 arguments
    $response = $this->stkPush(
        $phone,
        100,           // Amount you want to charge, e.g., 100 KES
        'ORDER-' . $id, // Account reference (can be order ID)
        'Order Payment' // Description
    );

    return response()->json($response);
}

}
