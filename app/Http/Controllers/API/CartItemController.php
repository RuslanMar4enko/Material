<?php

namespace App\Http\Controllers\API;

use App\CartItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    /**
     * @param CartItem $cartItem
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeQuantity(CartItem $cartItem, Request $request)
    {
        $credentials = $request->only('quantity');
        $cartItem->update($credentials);
        return response()->json(['status' => true]);
    }

    /**
     * @param CartItem $cartItem
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function deleteCartItem(CartItem $cartItem)
    {
        if ($cartItem->delete()) {
            return response()->json(['status' => true]);
        }

        return response('', 500);
    }
}
