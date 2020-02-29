<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable =[
        'address',
        'full_name',
        'delivery',
        'phone',
    ];

    public function ordersProduct()
    {
        return $this->belongsToMany(Product::class, 'product_orders')
            ->withPivot('id', 'quantity')
            ->withTimestamps();
    }

}
