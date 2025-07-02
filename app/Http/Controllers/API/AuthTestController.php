<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthTestController extends Controller
{
    public function getToken(Request $request) {
     $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $response = Http::asForm()->post('http://127.0.0.1:8001/oauth/token', [
            'grant_type' => 'password',
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'username' => $request->email,
            'password' => $request->password ,
            'scope' => '*',
        ]);
        
        if ($response->successful()) {
            return response()->json([
            'message' => 'success to obtain token',
            'data' => $response->json()
        ]);


        }
        return $response->json([
            "message" => 'Failed to obtain token',
            "data" => $response->json()
        ]);
        }


}