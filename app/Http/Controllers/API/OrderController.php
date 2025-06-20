<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Str;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Order::with(['customer', 'items', 'payment'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,paid,cancelled',
        ]);
        
        $totalAmount = 0;
        foreach($request->items as $item) {
            $product = Product::find($item['product_id']);
            $totalAmount += $product->price * $item['quantity'];

        }
         return Order::create([
            "order_number" => strtoupper(Str::random(8)),
            "customer_id" => $validated['customer_id'],
            "status" => $validated['status'],
            "total_amount" => $totalAmount,
        ]);

        foreach($request->items as $item) {
            $product = Product::find($item['product_id']);
            $totalAmount += $product->price * $item['quantity'];

        

            if (!$product) {
                continue;
            }
            OrderItem::create([
                "order_id" => $order->id,
                "product_id" => $item['product_id'],
                "quantity" => $item['quantity'],
                "price" => $product->price,
                "total_price" => $product->price * $item['quantity'],
            ]);
           
        }
        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order_number,
        ]);
    }
    

    public function show($id) {
    $order = Order::with(['customer', 'items.product', 'payment'])->findOrFail($id);

    $paymentStatus = 'pending';
    $paymentMethod = null;

    if ($order->payment) {
        $paymentStatus = $order->payment->status;
        $paymentMethod = $order->payment->method;
    } elseif ($order->status === 'cancelled') {
        $paymentStatus = 'cancelled';
    }

    $products = [];

    foreach ($order->items as $item) {
        $product = $item->product; // Assuming OrderItem has a relationship 'product'
        $products[] = [
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'quantity' => $item->quantity,
            'total_price' => $item->total_price,
        ];
    }

    $response = $order->toArray();
    $response['products'] = $products;
    $response['payment'] = [
        'status' => $paymentStatus,
        'method' => $paymentMethod,
    ];

    return response()->json($response);
}


    public function update(Request $request, Order $order) {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_number' => 'required|unique:orders,order_number,' . $order->id,
            'status' => 'required|in:pending,paid,cancelled',
            'total_amount' => 'required|numeric',
        ]);
        $order->update($validated);
        $order->refresh();
        return response()->json($order->load(['customer','items','payment']));
    }

    public function destroy(Order $order) {
        $order->delete();
        return response()->noContent();
    }
}