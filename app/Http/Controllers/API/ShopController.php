<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopResources;
use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt');
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
     * @param ShopResources $request
     * @return ShopResources
     */
    public function store(Shop $shop, ShopResources $request)
    {
        $shop->fill($request->all());
        $shop->user_id = Auth::id();
        $shop->save();

        return new ShopResources($shop);
    }

    /**
     * @param Shop $shop
     * @return ShopResource
     */
    public function show(Shop $shop)
    {
        return new ShopResource($shop);
    }

    /**
     * @param Shop $shop
     * @param ShopResources $request
     * @return ShopResources
     */
    public function update(Shop $shop, ShopResources $request)
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

}
