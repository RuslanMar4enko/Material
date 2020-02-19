<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ShopRequest;
use App\Shop;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShopResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
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
    public function store(Shop $shop, ShopRequest $request)
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
        $shop->productOrder()->detach();
        $shop->product()->delete();
        if ($shop->delete()) {
            return response()->json(['ok' => true]);
        }

        return response('', 500);
    }

}
