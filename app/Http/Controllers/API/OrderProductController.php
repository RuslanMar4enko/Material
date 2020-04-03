<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\ProductOrder;
use Illuminate\Http\Request;

class OrderProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api' );
    }

    /**
     * @param ProductOrder $productOrder
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeQuantity(ProductOrder $productOrder, Request $request)
    {
        $credentials = $request->only('quantity');
        $productOrder->update($credentials);
        return response()->json(['status' => true]);
    }

    /**
     * @param ProductOrder $productOrder
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Exception+
     * 
     */
    public function deleteOrderItem(ProductOrder $productOrder)
    {
        if ($productOrder->delete()) {
            return response()->json(['status' => true]);
        }

        return response('', 500);
    }
}
