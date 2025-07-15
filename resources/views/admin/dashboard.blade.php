@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-900 text-white min-h-screen">
    <h1 class="text-2xl font-bold mb-4"> Jamaa Supermarket Dashboard</h1>

    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-gray-800 rounded p-4">
            <p>Sales Total</p>
            <h2 class="text-green-400 text-xl font-bold">Ksh {{ number_format($salesTotal) }}</h2>
        </div>
        <div class="bg-gray-800 rounded p-4">
            <p>Expenses Total</p>
            <h2 class="text-red-400 text-xl font-bold">Ksh {{ number_format($expensesTotal) }}</h2>
        </div>
        <div class="bg-gray-800 rounded p-4">
            <p>Stocks Total</p>
            <h2 class="text-blue-400 text-xl font-bold">Ksh {{ number_format($stocksTotal) }}</h2>
        </div>
        <div class="bg-gray-800 rounded p-4">
            <p>Revenue</p>
            <h2 class="text-green-400 text-xl font-bold">Ksh {{ number_format($revenue) }}</h2>
        </div>
    </div>

    <div class="bg-gray-800 rounded p-4 mb-6">
        <h2 class="text-lg font-semibold mb-2">Top Selling Items</h2>
        @foreach($topItems as $item)
            <div class="flex justify-between border-b border-gray-700 py-1">
                <span>{{ $item['name'] }} ({{ $item['quantity'] }} pcs)</span>
                <span class="@if($item['status'] === 'GOOD') text-green-400 @else text-yellow-400 @endif">{{ $item['status'] }}</span>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div class="bg-gray-800 rounded p-4">
            <h2 class="text-lg font-semibold mb-2">Top Categories (by Expense)</h2>
            @foreach($topCategories as $category)
                <div class="flex justify-between border-b border-gray-700 py-1">
                    <span>{{ $category['name'] }}</span>
                    <span class="text-blue-400">{{ number_format($category['amount']) }}</span>
                </div>
            @endforeach
        </div>
        <div class="bg-gray-800 rounded p-4">
            <h2 class="text-lg font-semibold mb-2">Top Customer</h2>
            <p>{{ $topCustomer['name'] }}</p>
            <h2 class="text-green-400 font-bold">Ksh {{ number_format($topCustomer['amount']) }}</h2>
        </div>
    </div>
</div>
@endsection
