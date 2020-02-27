<?php

namespace App\Http\Controllers\API;

use App\CartItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function changeQuantity(CartItem $cartItem, Request $request)
    {
        $credentials = $request->only('quantity');
        $cartItem->update($credentials);
        return response()->json(['status' => true]);
    }

    public function deleteCartItem(CartItem $cartItem)
    {
        if ($cartItem->delete()) {
            return response()->json(['status' => true]);
        }

        return response('', 500);
    }
}
