@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Business Reports</h1>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="mb-4">Monthly Sales: <span class="font-semibold">Ksh 15,200,000</span></p>
        <p class="mb-4">Monthly Expenses: <span class="font-semibold">Ksh 3,500,000</span></p>
        <p class="mb-4">Net Profit: <span class="font-semibold text-green-600">Ksh 11,700,000</span></p>

        <h2 class="text-xl font-semibold mb-2">Top Selling Categories</h2>
        <ul class="list-disc pl-6">
            <li>Groceries</li>
            <li>Fresh Produce</li>
            <li>Household Supplies</li>
        </ul>
    </div>
</div>
@endsection
