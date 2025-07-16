@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow">
    <h1 class="text-3xl font-bold mb-6">Orders</h1>

    <input type="search" placeholder="Search orders" class="w-full mb-4 p-3 border rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-300" />

    <table class="w-full table-auto border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3 border border-gray-200 text-left">Order ID</th>
                <th class="p-3 border border-gray-200 text-left">Customer Name</th>
                <th class="p-3 border border-gray-200 text-left">Order Date</th>
                <th class="p-3 border border-gray-200 text-left">Status</th>
                <th class="p-3 border border-gray-200 text-left">Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr class="border border-gray-200 hover:bg-gray-50">
                <td class="p-3 border border-gray-200">
                    <a href="{{ route('orders.show', $order->id) }}" class="text-indigo-600 hover:underline">#{{ $order->order_number }}</a>
                </td>
                <td class="p-3 border border-gray-200">{{ $order->user->name ?? 'N/A' }}</td>
                <td class="p-3 border border-gray-200">{{ $order->created_at->format('Y-m-d') }}</td>
                <td class="p-3 border border-gray-200">
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                        @if($order->status == 'Pending') bg-yellow-200 text-yellow-800
                        @elseif($order->status == 'Shipped') bg-blue-200 text-blue-800
                        @elseif($order->status == 'Delivered') bg-green-200 text-green-800
                        @elseif($order->status == 'Pickup') bg-purple-200 text-purple-800
                        @else bg-gray-200 text-gray-800 @endif">
                        {{ $order->status }}
                    </span>
                </td>
                <td class="p-3 border border-gray-200">${{ number_format($order->total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
