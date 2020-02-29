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
    /**
     * @return CartResources
     */
    public function storeCart()
    {
        $cart = Cart::create([
            'id' => md5(uniqid(rand(), true)),
            'user_id' => Auth::id() ? Auth::id() : null
        ]);
        return new CartResources($cart);
    }

    /**
     * @param Cart $cart
     * @param CratProductRequest $request
     * @return CratProductResources
     */
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

    /**
     * @param Cart $cart
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
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

    /**
     * @param Cart $cart
     * @param FileCsvRequest $request
     * @return array|\Exception
     */
    public function csvSaveToCart(Cart $cart, FileCsvRequest $request)
    {
        try {
            $cartProducts = Excel::toArray(new ImportToCart(), $request->file('file'));
            $syncCart = $this->checkProduct($cartProducts);
            $cart->productsItems()->sync($syncCart);
            return ['status' => true];
        } catch (\Exception $e) {
            return $e;
        }

    }

    /**
     * @param $cartProducts
     * @return array
     */
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

    /**
     * @param Cart $cart
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function removeCartItem(Cart $cart) {
        if ($cart->productsItems()->detach()) {
            return response()->json(['status' => true]);
        }

        return response('', 500);
    }

}
