<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
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

     public function deleteOrder(Order $order) {
         if ($order->delete()) {
             return response()->json(['ok' => true]);
         }

         return response('', 500);
     }


    public function getOrders(Order $order){

        return OrderResources::collection(
            $order->productOrders()
        );
    }
}
