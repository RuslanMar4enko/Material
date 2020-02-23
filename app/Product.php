<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'id',
        'shop_id',
        'sku',
        'brand',
        'name',
        'price',
        'image',
        'description'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }


}
