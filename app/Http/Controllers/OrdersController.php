<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product', 'payment'])->findOrFail($id);
        return view('admin.order_show', compact('order'));
    }
}
