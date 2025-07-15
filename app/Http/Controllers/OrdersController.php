<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientOrderController extends Controller
{
    public function index()
    {
        public function allOrders()
    {
        $orders = Order::with(['user:id,name,email', 'items.product:id,name,price,image', 'payment'])
                       ->orderBy('created_at', 'desc')
                       ->get();

        return response()->json($orders->map(function($o){
            return [
                    'id'               => $o->id,
                    'order_number'     => $o->order_number,
                    'total'            => $o->total,
                    'status'           => $o->status,
                    'payment_status'   => $o->payment_status,
                    'shipping_status'  => $o->shipping_status, 
                    'customer'         => $o->user,
                    'payment'=>[
                        'receipt'=>$o->payment->mpesa_receipt ?? null,
                        'amount'=> $o->payment->amount ?? null,
                        'status'=> $o->payment->status ?? null,
                    ],
                    'items' => $o->items->map(fn($item) => [
                        'id'       => $item->id,
                        'name'     => $item->product->name,
                        'description' => $item->product->description,
                        'price'    => $item->price,
                        'quantity' => $item->quantity,
                        'total_price' => $item->price * $item->quantity,
                    ]),
                ];
            }));
    }
        return view('admin.order', $orders);
    }
}
