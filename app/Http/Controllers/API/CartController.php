<?php

namespace App\Http\Controllers\API;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CartController extends Controller
{

    public function createCart()
    {
        $cart = Cart::create([
            'id' => Hash::make(uniqid(rand(), true)),
            'key' => Hash::make(uniqid(rand(), true))
        ]);

        return new CartResources($cart);
    }
}
