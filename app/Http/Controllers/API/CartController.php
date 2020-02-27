<?php

namespace App\Http\Controllers\API;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\CratProductRequest;
use App\Http\Requests\FileCsvRequest;
use App\Http\Resources\CartResources;
use App\Http\Resources\CratProductResources;
use App\Http\Resources\ProuctsCratResources;
use App\Imports\ImportToCart;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CartController extends Controller
{

    public function storeCart()
    {
        $cart = Cart::create([
            'id' => md5(uniqid(rand(), true)),
            'user_id' => Auth::id() ? Auth::id() : null
        ]);
        return new CartResources($cart);
    }

    public function addProduct(Cart $cart, CratProductRequest $request)
    {
        $cart = $cart->find($request->cartKey);
        $cartItem = $cart->items()
            ->firstOrNew(['product_id' => $request->productId]);
        $cartItem->cart_id = $cart->id;
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
                'products.price',
                'products.shop_id',
            ])
        );
    }

    public function csvSaveToCart(Cart $cart, FileCsvRequest $request)
    {
        try {
            $cartProducts = Excel::toArray(new ImportToCart(), $request->file('file'));
            $syncCart = $this->checkProduct($cartProducts);
            $cart->productsItems()->sync($syncCart);
            return ['status' => $syncCart];
        } catch (\Exception $e) {
            return $e;
        }

    }

    private function checkProduct($cartProducts): array
    {
        $arraySyncProduct = [];
        foreach ($cartProducts[0] as $cartProduct) {
            if (Product::find($cartProduct['product_id'])) {
                $arraySyncProduct[$cartProduct['product_id']] = ['quantity' => $cartProduct['quantity']];
            }
        }

        return $arraySyncProduct;
    }

}
