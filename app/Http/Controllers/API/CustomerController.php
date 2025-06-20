<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index() {
        return Customer::all();
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:customers,email',
            'address' => 'required',
        ]);
        return Customer::create($validated);
    }

    public function show(Customer $customer) {
        return $customer;
    }

    public function update(Request $request, Customer $customer) {
        $validated = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'address' => 'required',
        ]);
        $customer->update($validated);
        $customer->refresh();
        return response()->json($customer);
    }

    public function destroy(Customer $customer) {
        $customer->delete();
        return response()->noContent();
    }
}