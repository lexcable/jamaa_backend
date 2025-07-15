@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Recent Orders</h1>

    <div class="bg-white rounded-lg shadow-md p-6">
        <p class="mb-4">Total Orders This Month: <span class="font-semibold">1,245</span></p>

        <table class="w-full table-auto">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Order ID</th>
                    <th class="border px-4 py-2">Customer</th>
                    <th class="border px-4 py-2">Amount</th>
                    <th class="border px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-4 py-2">ORD12345</td>
                    <td class="border px-4 py-2">John Doe</td>
                    <td class="border px-4 py-2">Ksh 4,560</td>
                    <td class="border px-4 py-2 text-green-600">Completed</td>
                </tr>
                <!-- Repeat rows as needed -->
            </tbody>
        </table>
    </div>
</div>
@endsection
