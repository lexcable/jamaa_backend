<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'total',
        'status',
        'payment_status',
        'customer_id',
        'delivery_state',
        'payment_method',
    ];

    // Auto-generate order_number on creation
    protected static function booted()
    {
        static::creating(function ($order) {
            $order->order_number = 'ORD-'.Str::upper(Str::random(8));
        });
    }

    // An order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    // An order has many order items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function getTotalAmountAttribute() {
        return $this->items->sum(fn($i) => $i->price * $i->quantity);
    }
}
