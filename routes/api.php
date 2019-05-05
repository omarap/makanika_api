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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::post('reset_password', 'UserController@resetPassword');
Route::get('/products', 'ProductController@index');
Route::post('/upload-file', 'ProductController@uploadFile');
Route::get('/products/{product}', 'ProductController@show');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/users','UserController@index');
    Route::get('users/{user}','UserController@show');
    Route::patch('users/{user}','UserController@update');
    Route::get('users/{user}/orders','UserController@showOrders');
    Route::patch('products/{product}/units/add','ProductController@updateUnits');
    Route::patch('orders/{order}/deliver','OrderController@deliverOrder');
    Route::resource('/orders', 'OrderController');
    Route::resource('/products', 'ProductController')->except(['index','show']);
});

//product end points
Route::post('/product', 'ProductController@store');
Route::put('/products/{product}', 'ProductController@update');
Route::delete('/products/{product}', 'ProductController@destroy');

//review end points
Route::post('/review', 'ReviewController@store');
Route::put('/reviews/{review}', 'ReviewController@update');
Route::get('/reviews', 'ReviewController@index');
Route::delete('/reviews/{review}', 'ReviewController@destroy');

Route::apiResource('/reviews','ReviewController');
Route::group(['prefix'=>'products'],function(){
    Route::apiResource('/{product}/reviews', 'ReviewController');
});


//category end points
Route::post('/category', 'CategoryController@store');
Route::put('/categories/{category}', 'CategoryController@update');
Route::get('/categories', 'CategoryController@index');
Route::delete('/categories/{category}', 'CategoryController@destroy');

//order end points
Route::post('/order', 'OrderController@store');
Route::put('/orders/{orders}', 'OrderController@update');
Route::get('/orders', 'OrdersController@index');
Route::delete('/orders/{order}', 'OrderController@destroy');