@extends('layouts.app')
@section('title', 'Customer Orders')
@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow space-y-6">
    <h1 class="text-2xl font-bold">Orders for {{ $customer->name }}</h1>
    @foreach($customer->orders as $order)
    <div class="border rounded p-4">
        <h2 class="font-semibold">Order #{{ $order->id }} — {{ $order->created_at->format('Y-m-d') }}</h2>
        <p>Delivery: {{ ucfirst($order->delivery_state) }} | Payment: {{ ucfirst($order->payment_method) }} ({{ ucfirst($order->payment_status) }})</p>
        <table class="w-full mt-2 table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Order_ID</th>
                    <th class="p-2">Category</th>
                    <th class="p-2">Product</th>
                    <th class="p-2">Description</th>
                    <th class="p-2">Price</th>
                    <th class="p-2">Qty</th>
                    <th class="p-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td class="p-2">{{ $item->product_name }}</td>
                    <td class="p-2">{{ $item->description }}</td>
                    <td class="p-2">KES {{ number_format($item->price,2) }}</td>
                    <td class="p-2">{{ $item->quantity }}</td>
                    <td class="p-2">KES {{ number_format($item->price * $item->quantity,2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-semibold">
                    <td colspan="4" class="p-2 text-right">Total:</td>
                    <td class="p-2">KES {{ number_format($order->total_amount,2) }}</td>
                </tr>
            </tfoot>
        </table>

    </div> 
    @endforeach
</div>
@endsection