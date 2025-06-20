<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;

class OrderItemController extends Controller
{
    public function index()
    {
        return OrderItem::with(['order', 'product'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'total_price' => 'required|numeric',
        ]);

        return OrderItem::create($validated);
    }

    public function show($id)
    {
        $orderItem = OrderItem::with(['order', 'product'])->findOrFail($id);

        $response = $orderItem->toArray();

        // Customize order info
        if ($orderItem->order) {
            $response['order'] = [
                'id' => $orderItem->order->id,
                'order_number' => $orderItem->order->order_number,
                'status' => $orderItem->order->status,
                'total_amount' => $orderItem->order->total_amount,
                'customer_id' => $orderItem->order->customer_id,
            ];
        }

        // Customize product info
        if ($orderItem->product) {
            $response['product'] = [
                'id' => $orderItem->product->id,
                'name' => $orderItem->product->name,
                'description' => $orderItem->product->description,
                'price' => $orderItem->product->price,
                'stock' => $orderItem->product->stock,
            ];
        }

        return response()->json($response);
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'total_price' => 'required|numeric',
        ]);
        $orderItem->update($validated);
        $orderItem->refresh();
        return response()->json($orderItem);
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();
        return response()->noContent();
    }
}
