<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResources;
use App\Order;
use http\Env\Request;

class OrderController extends Controller
{
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

    public function deleteOrder(Order $order)
    {
        $order->productOrders()->detach();
        if ($order->delete()) {
            return response()->json(['ok' => true]);
        }

        return response('', 500);
    }


    public function getProductOrder(Order $order, Request $request)
    {
        return OrderResources::collection(
            $order->productOrders()->where('products.shop_id', $request->shopId)
        );
    }

    public function updateOrder(UpdateOrderRequest $request, Order $order)
    {
        return new OrderResources(
            $order->update($request->all())
        );
    }
}
