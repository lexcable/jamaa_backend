<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    // 👑 ADMIN: Get all orders
    public function allOrders()
    {
        $orders = Order::with(['user:id,name,email', 'items.product:id,name,price,image', 'payment'])
                       ->orderBy('created_at', 'desc')
                       ->get();

        return response()->json($orders->map(function($o){
            return [
                    'id'               => $o->id,
                    'order_number'     => $o->order_number,
                    'total'            => $o->total,
                    'status'           => $o->status,
                    'payment_status'   => $o->payment_status,
                    'shipping_status'  => $o->shipping_status, 
                    'customer'         => $o->user,
                    'payment'=>[
                        'receipt'=>$o->payment->mpesa_receipt ?? null,
                        'amount'=> $o->payment->amount ?? null,
                        'status'=> $o->payment->status ?? null,
                    ],
                    'items' => $o->items->map(fn($item) => [
                        'id'       => $item->id,
                        'name'     => $item->product->name,
                        'description' => $item->product->description,
                        'price'    => $item->price,
                        'quantity' => $item->quantity,
                        'total_price' => $item->price * $item->quantity,
                    ]),
                ];
            }));
    }

    // 👤 CLIENT: Get their own orders
    public function index()
    {
        $orders = Order::with(['items.product:id,name,price,image'])
                       ->where('user_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->get();

        $payload = $orders->map(fn($order) => [
            'id'               => $order->id,
            'order_number'     => $order->order_number,
            'total'            => $order->total,
            'status'           => $order->status,
            'payment_status'   => $order->payment_status,
            'payment'=>[
                'receipt'=>$order->payment->mpesa_receipt ?? null,
                'amount'=> $order->payment->amount ?? null,
                'status'=> $order->payment->status ?? null,
            ],
            'shipping_status'  => $order->shipping_status,
            'created_at'       => $order->created_at,
            'items'            => $order->items->map(fn($item) => [
                'id'       => $item->id,
                'name'     => $item->product->name,
                'description' => $item->product->description,
                'price'    => $item->price,
                'quantity' => $item->quantity,
                'total_price' => $item->price * $item->quantity,
            ]),
        ]);

        return response()->json($payload);
    }

    // 👤 CLIENT: Get specific order (must be theirs)
    public function show($id)
    {
        $order = Order::with(['items.product:id,name,price,image'])
                      ->where('id', $id)
                      ->where('user_id', Auth::id())
                      ->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found or unauthorized'], 404);
        }

       return response()->json([
        'id'               => $order->id,
        'order_number'     => $order->order_number,
        'total'            => $order->total,
        'status'           => $order->status,
        'payment_status'   => $order->payment_status,
        'payment'=>[
                    'receipt'=>$order->payment->mpesa_receipt ?? null,
                    'amount'=> $order->payment->amount ?? null,
                    'status'=> $order->payment->status ?? null,
                    ],
        'shipping_status'  => $order->shipping_status,   // ← add this
        'created_at'       => $order->created_at,
        'items'            => $order->items->map(fn($item) => [
            'id'       => $item->id,
            'product'  => [
                'id'    => $item->product->id,
                'name'  => $item->product->name,
                'price' => $item->product->price,
                'image' => $item->product->image,
            ],
            'quantity' => $item->quantity,
            'price'    => $item->price * $item->quantity, // total price for this item
        ]),
    ]);
    }

    // 👤 CLIENT: Place new order
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $total = 0;

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $total += $product->price * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'status' => 'pending',
        ]);

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
        }

        return response()->json(['message' => 'Order placed successfully', 'order_id' => $order->id], 201);
    }

    // 👑 ADMIN: Update order status
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return response()->json(['message' => 'Order updated successfully']);
    }

    public function updateShipping(Request $request, $id)
        {
            $order = Order::findOrFail($id);

            $request->validate([
                'shipping_status' => 'required|in:pending,shipped,delivered'
            ]);

            $order->update(['shipping_status' => $request->shipping_status]);

            return response()->json(['message' => 'Shipping status updated.']);
        }

    // 👑 ADMIN: Delete an order
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}