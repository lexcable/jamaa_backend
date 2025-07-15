@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Stocks Overview</h1>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="mb-4">Total Products in Stock: <span class="font-semibold">12,500 items</span></p>
        <p class="mb-4">Out of Stock Products: <span class="font-semibold text-red-600">56 items</span></p>

        <h2 class="text-xl font-semibold mb-2">Low Stock Alerts</h2>
        <ul class="list-disc pl-6">
            <li class="mb-2">Cooking Oil - 10 units left</li>
            <li class="mb-2">Toothpaste - 4 units left</li>
            <li class="mb-2">Bottled Water - 15 units left</li>
        </ul>
    </div>
</div>
@endsection
