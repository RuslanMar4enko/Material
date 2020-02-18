<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'full_name',
        'phone_number',
    ];

    public function product()
    {
        return $this->hasMany(Product::class);
    }

}
