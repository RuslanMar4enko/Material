<?php

namespace App\Http\Controllers\API;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\CratProductRequest;
use App\Http\Resources\CartResources;
use App\Http\Resources\CratProductResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CartController extends Controller
{

    public function storeCart()
    {
        $cart = Cart::create([
            'id' => Hash::make(uniqid(rand(), true)),
            'user_id' => Auth::id() ? Auth::id() : null
        ]);
        return new CartResources($cart);
    }

    public function addProduct(Cart $cart, CratProductRequest $request)
    {
        $cartItem = $cart->find($request->cartKey)->items()
            ->firstOrNew(['product_id' => $request->productId]);
        $cartItem->cart_id = $request->cartKey;
        $cartItem->quantity += 1;
        $cartItem->save();

        return new CratProductResources($cartItem);
    }

    public function getProductsItemsCarrt()
    {

    }
}
