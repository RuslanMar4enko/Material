<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Images extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Images';
    }

}