<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;

class OrderItemController extends Controller
{
    public function index()
    {
        return OrderItem::with('product:id,name,price', 'order:id,order_number')->get();
    }

    public function show($id)
    {
        return OrderItem::with('product', 'order')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id'   => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'price'      => 'required|numeric|min:0',
        ]);

        $item = OrderItem::create($validated);
        return response()->json($item, 201);
    }

    public function update(Request $request, $id)
    {
        $item = OrderItem::findOrFail($id);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'price'    => 'required|numeric|min:0',
        ]);

        $item->update($validated);
        return response()->json($item);
    }

    public function destroy($id)
    {
        $item = OrderItem::findOrFail($id);
        $item->delete();

        return response()->json(null, 204);
    }
}
