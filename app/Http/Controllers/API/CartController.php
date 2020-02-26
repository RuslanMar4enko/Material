<?php

namespace App\Http\Controllers\API;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'user_id' => Auth::id() ? Auth::id() : null
        ]);
        return new CartResources($cart);
    }

    public function show()
    {

    }

    public function addProduct(Cart $cart, Request $request)
    {
        $cartItem = $cart->find($request->cartId)->items()
            ->firstOrNew(['product_id' => $request->productId]);
        $cartItem->cart_id = $request->cartId;
        $cartItem->quantity += $request->quantity;
        $cartItem->save();
        var_dump($cartItem);
        die();
    }


}
