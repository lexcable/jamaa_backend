<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_id','order_number','status','total_amount'];
    public function customer() {
         return $this->belongsTo(Customer::class); }
    public function items()    { 
        return $this->hasMany(OrderItem::class); }
    public function payment()  {
         return $this->hasOne(Payment::class); }
    public function orderItems () {
        return $this->hasMany(OrderItem::class);
    }
}
