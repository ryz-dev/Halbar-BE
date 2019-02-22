<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $fillable = ['fullname', 'email'];

    public function checkout()
    {
        return $this->hasMany(Checkout::class, 'users_id', 'id');
    }
}
