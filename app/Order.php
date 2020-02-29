<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable =[
        'order_id',
        'address',
        'full_name',
        'delivery',
        'phone',
    ];

    public function productOrders()
    {
        return $this->belongsToMany(Product::class, 'product_orders')
            ->withTimestamps();
    }

}
