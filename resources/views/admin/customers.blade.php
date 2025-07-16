
@extends('layouts.app')
@section('title','Customers')
@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded-xl shadow">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Customers</h1>
        <a href="{{ route('customers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Add Customer</a>
    </div>
    <input type="search" placeholder="Search customers" class="w-full mb-4 p-2 border rounded" />
    <table class="w-full table-auto">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">ID</th>
                <th class="p-2">Name</th>
                <th class="p-2">Email</th>
                <th class="p-2">Phone</th>
                <th class="p-2">Registered</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $c)
            <tr class="hover:bg-gray-50">
                <td class="p-2">{{ $c->id }}</td>
                <td class="p-2">
                    <a href="{{ route('customers.show',$c) }}" class="text-blue-600 hover:underline">{{ $c->name }}</a>
                </td>
                <td class="p-2">{{ $c->email }}</td>
                <td class="p-2">{{ $c->phone }}</td>
                <td class="p-2">{{ $c->registration_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">{{ $customers->links() }}</div>
</div>
@endsection