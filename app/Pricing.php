<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    protected $table = 'pricing';

    public function items()
    {
        return $this->hasMany(PricingItem::class, 'pricing', 'id');
    }
}
