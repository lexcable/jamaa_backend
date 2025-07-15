@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Expenses Breakdown</h1>

    <div class="bg-white rounded-lg shadow-md p-6">
        <ul class="list-disc pl-6">
            <li class="mb-2">Salaries: Ksh 1,000,000</li>
            <li class="mb-2">Utilities: Ksh 200,000</li>
            <li class="mb-2">Rent: Ksh 300,000</li>
            <li class="mb-2">Inventory Purchases: Ksh 1,500,000</li>
            <li class="mb-2">Marketing: Ksh 200,000</li>
        </ul>
    </div>
</div>
@endsection
