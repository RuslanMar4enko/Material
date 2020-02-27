<?php

namespace App\Http\Controllers;

use App\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function changeQuantity(CartItem $cartItem, Request $request)
    {
        $credentials = $request->only('quantity');
        $cartItem->update($credentials);
        return response()->json(null, 200);
    }

    public function deleteCartItem(CartItem $cartItem)
    {
        $cartItem->delete();
        return response()->json(null, 204);
    }
}
