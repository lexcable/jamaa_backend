<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->has(['start_date', 'end_date'])) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.report', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product', 'payment'])->findOrFail($id);
        return view('admin.report_show', compact('order'));
    }

    public function stockReport()
    {
        // Fetch products data to pass to the stock view
        $products = \App\Models\Product::all();
        return view('admin.stock', compact('products'));
    }

    public function revenueReport()
    {
        // Fetch categories and targets data for budget view
        $categories = [
            'groceries' => [
                'label' => 'Groceries',
                'items' => [
                    'fruits' => 'Fruits',
                    'vegetables' => 'Vegetables',
                    'meat' => 'Meat',
                ],
            ],
            'utilities' => [
                'label' => 'Utilities',
                'items' => [
                    'electricity' => 'Electricity',
                    'water' => 'Water',
                    'internet' => 'Internet',
                ],
            ],
        ];

        $targets = []; // Fetch or initialize budget targets data
        $actuals = []; // Fetch or initialize actual spending data

        return view('admin.budget', compact('categories', 'targets', 'actuals'));
    }

    public function expenseReport()
    {
        // Return the existing expenses view.
        return view('admin.expenses');
    }
}
