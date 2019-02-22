<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checkout extends Model
{
    protected $table = 'checkout';
    protected $fillable = ['users_id', 'company_id', 'pricing_items_id', 'status','date','invoice'];

    public $timestamps = false;

    public function pricing()
    {
        return $this->hasOne(PricingItem::class, 'id', 'pricing_items_id');
    }
}
