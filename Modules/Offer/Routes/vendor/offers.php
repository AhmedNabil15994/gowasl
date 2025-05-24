<?php
use Illuminate\Support\Facades\Route;

Route::name('vendor.')->group( function () {

    Route::get('offers/datatable'	,'OfferController@datatable')
        ->name('offers.datatable');

    Route::get('offers/deletes'	,'OfferController@deletes')
        ->name('offers.deletes');

    Route::resource('offers','OfferController')->names('offers');
});
