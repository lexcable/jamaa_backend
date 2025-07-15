@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Supermarket Budget Overview</h1>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="text-gray-700 mb-2">Total Budget: <span class="font-semibold">Ksh 5,000,000</span></p>
        <p class="text-gray-700 mb-2">Allocated Budget: <span class="font-semibold">Ksh 3,200,000</span></p>
        <p class="text-gray-700 mb-2">Remaining Budget: <span class="font-semibold">Ksh 1,800,000</span></p>
        <p class="text-gray-700">Budget Cycle: <span class="font-semibold">January - December 2025</span></p>
    </div>
</div>
@endsection
