<?php

use Illuminate\Support\Facades\Route;

Route::get('/checkout', 'OrderController@createView')->name('frontend.order.create.view');
Route::get('/checkout/getOrderDetails', 'OrderController@getOrderDetails')->name('frontend.order.getOrderDetails');
Route::post('/checkout', 'OrderController@payOrder')->name('frontend.order.create');
Route::get('order-completed', 'OrderController@orderCompleted')->name('frontend.orders.completed');


Route::get('success-upayment', 'OrderController@successUpayment')->name('frontend.orders.success.upayment');
Route::get('success-tap', 'OrderController@successTap')->name('frontend.orders.success.tap');
Route::get('myfatoorah-callback', 'OrderController@myFatoorahCallBack')->name('frontend.orders.myfatoorah.callback');

Route::get('success', 'OrderController@success')->name('frontend.orders.success');
Route::get('failed', 'OrderController@failed')->name('frontend.orders.failed');
