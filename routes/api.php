<?php

use Illuminate\Http\Request;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['api'], 'namespace' => 'API'], function () {
    Route::apiResources([
        'shops' => 'ShopController',
        'products' => 'ProductController',
    ]);
    Route::post('/carts/item', 'CartController@addProduct');
    Route::delete('/cart/item/{cart}', 'CartController@removeCartItem');
    Route::post('/carts', 'CartController@storeCart');
    Route::get('/cart/{cart}', 'CartController@getProductsItemsCart');
    Route::post('/cart/import/{cart}', 'CartController@csvSaveToCart');
    Route::delete('/cart/{cartItem}', 'CartItemController@deleteCartItem');
    Route::put('/cart/{cartItem}', 'CartItemController@changeQuantity');
    Route::post('/order', 'OrderController@saveOrder');
    Route::get('/orders/{order}', 'OrderController@getProductOrder');
    Route::delete('/orders/{order}', 'OrderController@deleteOrder');
    Route::put('/orders/{order}', 'OrderController@updateOrder');
    Route::get('/cart/orders/{shop}', 'ShopController@getShopOrder');
});


Route::post('login', 'ApiAuthController@login');
Route::group(['middleware' => ['api'], 'prefix' => 'auth'], function () {
    Route::post('login', 'ApiAuthController@login');
    Route::post('logout', 'ApiAuthController@logout');
    Route::post('refresh', 'ApiAuthController@refresh');
});

