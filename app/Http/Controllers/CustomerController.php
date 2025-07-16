<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller {
    public function index() {
        $customers = Customer::orderBy('name')->paginate(15);
        return view('admin.customers', compact('customers'));
    }

    public function show($id) {
        $customer = Customer::with('orders.items')->findOrFail($id);
        return view('admin.CustomersShow', compact('customer'));
    }

    public function create() {
        return view('admin.customers_create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'registration_date' => 'nullable|date',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
    }
}
