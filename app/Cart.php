<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'id',
        'key'
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }
}
