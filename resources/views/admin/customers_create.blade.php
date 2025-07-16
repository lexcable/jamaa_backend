@extends('layouts.app')

@section('title', 'Add Customer')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow mt-8">
    <h2 class="text-3xl font-bold text-center text-indigo-600 mb-6">Add New Customer</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customers.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label class="block mb-2 font-medium text-gray-700">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Customer Name"
                class="w-full px-4 py-2 bg-white text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-300 focus:outline-none" required>
        </div>

        <!-- Email -->
        <div>
            <label class="block mb-2 font-medium text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="customer@example.com"
                class="w-full px-4 py-2 bg-white text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-300 focus:outline-none" required>
        </div>

        <!-- Phone -->
        <div>
            <label class="block mb-2 font-medium text-gray-700">Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone Number"
                class="w-full px-4 py-2 bg-white text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-300 focus:outline-none">
        </div>

        <!-- Registration Date -->
        <div>
            <label class="block mb-2 font-medium text-gray-700">Registration Date</label>
            <input type="date" name="registration_date" value="{{ old('registration_date') }}"
                class="w-full px-4 py-2 bg-white text-gray-800 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-300 focus:outline-none">
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg shadow-lg transition-all">
                Save Customer
            </button>
        </div>
    </form>
</div>
@endsection
