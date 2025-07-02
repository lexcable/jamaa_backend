<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens,  HasFactory,  Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',        // admin or client
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // A user can have many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
