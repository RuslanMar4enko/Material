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
        try{
            return $this->hasMany(Product::class);
        }catch (\Exception $exception){
            var_dump($exception);
            die();
        }

    }

    public function productOrder()
    {
        return $this->belongsToMany(
            Order::class, 'product_orders',
            'order_id', 'shop_id')->withTimestamps();
    }

}
