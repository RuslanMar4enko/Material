<?php

namespace App\Http\Controllers\API;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\CratProductRequest;
use App\Http\Resources\CartResources;
use App\Http\Resources\CratProductResources;
use App\Http\Resources\ProuctsCratResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

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

    public function getProductsItemsCart(Cart $cart)
    {
        return ProuctsCratResources::collection(
            $cart->productsItems()->get([
                'products.id',
                'products.name',
                'products.image',
                'products.shop_id',
            ])
        );
    }

    private function saveOrUpdateItemsCart($cart, $productId, $quantity)
    {
        $cartItem = $cart->items()
            ->firstOrNew(['product_id' => $productId]);
        $cartItem->cart_id = $cart->id;
        $cartItem->quantity = $quantity;
        $cartItem->save();
    }

    public function csvSaveToCart(Cart $cart, Request $request)
    {
        $file = $request->file('file');
        $path = $file->getRealPath();
        if ($file->getClientOriginalExtension() === 'csv') {
            $datas = Excel::load($path, function ($reader) {
            })->all()->toArray();
            foreach ($datas as $data) {
                //TODO
                //Check
                var_dump($data);
//                $this->saveOrUpdateItemsCart($cart, )
            }
        }
    }
}
