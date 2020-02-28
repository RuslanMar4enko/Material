<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $hidden = ['laravel_through_key'];
    protected $fillable = [
        'id',
        'product_id',
        'order_id',
        'shop_id',
        'quantity',
        'price',
        'total_price'
    ];


}
