@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow">
    <h1 class="text-3xl font-bold mb-6">Order #{{ $order->order_number }}</h1>

    <div class="mb-4">
        <strong>Customer:</strong> {{ $order->user->name ?? 'N/A' }}<br>
        <strong>Order ID:</strong> {{ $order->id }}<br>
        <strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d') }}<br>
        <strong>Products:</strong> {{ $order->items->count() }}<br>
        <strong>price:</strong> ${{ number_format($order->total, 2) }}<br>
        <strong>Status:</strong> {{ $order->status }}<br>
        <strong>Payment Status:</strong> {{ $order->payment_status }}<br>
        <strong>Shipping Status:</strong> {{ $order->shipping_status }}<br>
        <strong>Shipping Address:</strong> {{ $order->shipping_address }}<br>
    </div>

    <table class="w-full table-auto border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3 border border-gray-200 text-left">Product</th>
                <th class="p-3 border border-gray-200 text-left">Description</th>
                <th class="p-3 border border-gray-200 text-left">Price</th>
                <th class="p-3 border border-gray-200 text-left">Quantity</th>
                <th class="p-3 border border-gray-200 text-left">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
            <tr class="border border-gray-200">
                <td class="p-3 border border-gray-200">{{ $item->product->name ?? 'N/A' }}</td>
                <td class="p-3 border border-gray-200">{{ $item->product->description ?? '' }}</td>
                <td class="p-3 border border-gray-200">${{ number_format($item->price, 2) }}</td>
                <td class="p-3 border border-gray-200">{{ $item->quantity }}</td>
                <td class="p-3 border border-gray-200">${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="font-semibold">
                <td colspan="4" class="p-3 border border-gray-200 text-right">Total:</td>
                <td class="p-3 border border-gray-200">${{ number_format($order->total, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
