<?php

namespace App\Http\Controllers\API;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CartController extends Controller
{
    public function index()
    {

    }

    public function store()
    {
        $cart = Cart::create([
            'id' => Hash::make(uniqid(rand(), true)),
            'key' => Hash::make(uniqid(rand(), true))
        ]);

        return new CartResources($cart);
    }

    public function show()
    {

    }

    public function addProduct(Cart $cart, Request $request)
    {
//        $cart->find($request->cartId)->items()
//            ->firstOrNew('product_id' => $request->productId);
    }
}
