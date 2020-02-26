<?php

use Illuminate\Http\Request;

//
//header("Access-Control-Allow-Origin: *");
//header('Access-Control-Allow-Methods: POST,GET,PUT,PATCH,OPTIONS');
//header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
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
    Route::post('/carts', 'CartController@storeCart');
    Route::get('/cart/{cart}', 'CartController@getProductsItemsCart');
    Route::get('/cart/import/{cart}', 'CartController@csvSaveToCart');
});


Route::post('login', 'ApiAuthController@login');
Route::group(['middleware' => ['api'], 'prefix' => 'auth'], function () {
    Route::post('login', 'ApiAuthController@login');
    Route::post('logout', 'ApiAuthController@logout');
    Route::post('refresh', 'ApiAuthController@refresh');
});

