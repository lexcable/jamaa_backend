@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Customer Database</h1>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="mb-4">Total Registered Customers: <span class="font-semibold">3,450</span></p>

        <ul class="list-disc pl-6">
            <li class="mb-2">Active Customers: 2,980</li>
            <li class="mb-2">Inactive Customers: 470</li>
            <li class="mb-2">Top Customer: Mary Njoki (Total Spend: Ksh 150,000)</li>
        </ul>
    </div>
</div>
@endsection
