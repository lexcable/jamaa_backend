<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index() {
        // Ensure get() is called to return a Collection, not a Builder
        return Payment::with('order')->get();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'method' => 'required|in:mpesa,cash,bank',
            'status' => 'required|in:pending,completed,failed',
            'paid_at' => 'nullable|date',
        ]);
        return Payment::create($validated);
    }

    public function show($id) {
        $payment = Payment::with('order')->findOrFail($id);

        $response = $payment->toArray();

        if ($payment->order) {
            $response['order'] = [
                'id' => $payment->order->id,
                'order_number' => $payment->order->order_number,
                'status' => $payment->order->status,
                'total_amount' => $payment->order->total_amount,
                'customer_id' => $payment->order->customer_id,
            ];
        }

        return response()->json($response);
    }

    public function update(Request $request, Payment $payment) {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'method' => 'required|in:mpesa,cash,bank',
            'status' => 'required|in:pending,completed,failed',
            'paid_at' => 'nullable|date',
        ]);
        $payment->update($validated);
        $payment->refresh();
        return response()->json($payment);
    }

    public function destroy(Payment $payment) {
        $payment->delete();
        return response()->noContent();
    }
}
