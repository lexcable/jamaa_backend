<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\AfricastalkingTrait;

class SmsController extends Controller
{
    use AfricastalkingTrait;

    public function send(Request $request)
    {
        $data = $request->validate([
            'phone'   => 'required|string',
            'message' => 'required|string',
        ]);

        try {
            $response = $this->sendSms($data['phone'], $data['message']);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
