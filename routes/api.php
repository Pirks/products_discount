<?php

use Illuminate\Http\Request;

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
Route::group(['prefix' => 'voucher'], function () {
    Route::post('/', ['uses' => 'VouchersController@store', 'as' => 'voucher.store']);
});

Route::group(['prefix' => 'product'], function () {
    Route::post('/', ['uses' => 'ProductsController@store', 'as' => 'api.product.store']);
    Route::post('/{product_id}/add_voucher/{voucher_id}', ['uses' => 'ProductsController@addVoucher', 'as' => 'api.product.add_voucher']);
    Route::delete('/{product_id}/remove_voucher/{voucher_id}', ['uses' => 'ProductsController@removeVoucher', 'as' => 'api.product.remove_voucher']);
    Route::put('/{product_id}/buy', ['uses' => 'ProductsController@buyProduct', 'as' => 'api.product.buy']);
});

//Route::resource('voucher', 'VouchersController');
