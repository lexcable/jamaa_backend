<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
      'order_id','checkout_request_id','mpesa_receipt',
      'amount','phone','status','raw_response'
    ];
  
    protected $casts = ['raw_response'=>'array'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
