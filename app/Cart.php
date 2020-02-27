<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $incrementing = false;
    protected $fillable = [
        'id',
        'user_id'
    ];

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function productsItems()
    {
        return $this->belongsToMany(Product::class, 'cart_items',
            'cart_id', 'product_id')->withPivot('quantity', 'id')
            ->withTimestamps();
    }
}
