<?php

namespace App\Http\Controllers\API;

use App\Facades\Images;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResources;
use App\Product;

class ProductController extends Controller
{
    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth.jwt')->except(['index']);
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ProductResources::collection(Product::paginate(25));
    }

    /**
     * @param Product $product
     * @param ProductRequest $request
     * @return ProductResources
     */
    public function store(Product $product, ProductRequest $request){
        $product->fill($request->all());
        $product->image = Images::nameImage($request->file('image'));
        $product->save();

        return new ProductResources($product);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Product $product)
    {
        if ($product->delete()) {
            return response()->json(['ok' => true]);
        }

        return response('', 500);
    }
}
