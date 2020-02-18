<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopResources;
use App\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request) {
        return ShopResources::collection(
            Shop::where('user_id', $request->user()->id)->get()
        );
    }

    public function store() {

    }
}
