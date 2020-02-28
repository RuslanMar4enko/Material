<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'company_name',
        'full_name',
        'phone_number',
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function productOrders() {
        return $this->hasManyThrough(
            ProductOrder::class, Product::class,
            'shop_id', 'product_id', 'id'
        )->distinct()->get(['order_id']);
    }

}
