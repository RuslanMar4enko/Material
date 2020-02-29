<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ShopRequest;
use App\Http\Resources\OrderResources;
use App\Order;
use App\Shop;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShopResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    /**
     * ShopController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['getShopOrder']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return ShopResources::collection(
            Shop::where('user_id', $request->user()->id)->get()
        );
    }

    /**
     * @param Shop $shop
     * @param ShopRequest $request
     * @return ShopResources
     */
    public function store(Shop $shop, ShopRequest $request)
    {
        $shop->fill($request->all());
        $shop->user_id = Auth::id();
        $shop->save();

        return new ShopResources($shop);
    }

    /**
     * @param Shop $shop
     * @return array
     */
    public function show(Shop $shop)
    {

        return ['data' => $shop->product()->latest()->get()];
    }

    /**
     * @param Shop $shop
     * @param ShopRequest $request
     * @return ShopResources
     */
    public function update(Shop $shop, ShopRequest $request)
    {
        $shop->fill($request->all());
        $shop->user_id = Auth::id();
        $shop->save();
        return new ShopResources($shop);
    }

    /**
     * @param Shop $shop
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Shop $shop)
    {
        if ($shop->delete()) {
            return response()->json(['ok' => true]);
        }

        return response('', 500);
    }

    public function getShopOrder(Shop $shop)
    {
        $ordersIds = $shop->productOrders();
        $orders = Order::whereIn('id', $ordersIds)->get();
        return response()->json(['data' => $orders]);
    }

}
