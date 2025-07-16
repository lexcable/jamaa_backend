<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
    protected $fillable = ['name','email','phone','registration_date'];

    public function orders() {
        return $this->hasMany(Order::class);
    }
}