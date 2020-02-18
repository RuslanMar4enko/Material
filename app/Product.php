<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'shop_id',
        'sku',
        'brand',
        'name',
        'price',
        'image',
        'description'
    ];
}
