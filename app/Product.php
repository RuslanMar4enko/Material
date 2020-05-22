<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Classes\SearchableTrait;

class Product extends Model
{
    use SearchableTrait;

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
