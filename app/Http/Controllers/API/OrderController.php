<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderProductsResources;
use App\Http\Resources\OrderResources;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['saveOrder']);
    }

    /**
     * @param OrderRequest $request
     * @return OrderResources
     */
    public function saveOrder(OrderRequest $request)
    {
        $order = Order::create([
            'address' => $request->address,
            'full_name' => $request->full_name,
            'delivery' => $request->delivery,
            'phone' => $request->phone,
        ]);

        if ($order) {
            $order->productOrders()->attach(array_filter($request->data));
        }

        return new OrderResources($order);
    }

    /**
     * @param Order $order
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function deleteOrder(Order $order)
    {
        $order->productOrders()->detach();
        if ($order->delete()) {
            return response()->json(['ok' => true]);
        }

        return response('', 500);
    }

    /**
     * @param Order $order
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getProductOrder(Order $order, Request $request)
    {
        return OrderProductsResources::collection(
            $order->ordersProduct()
                ->where('products.shop_id', $request->shopId)
                ->get([
                    'products.id',
                    'products.name',
                    'products.image',
                    'products.price',
                ]));
    }

    /**
     * @param UpdateOrderRequest $request
     * @param Order $order
     * @return OrderResources
     */
    public function updateOrder(UpdateOrderRequest $request, Order $order)
    {
        return new OrderResources(
            $order->update($request->all())
        );
    }
}
