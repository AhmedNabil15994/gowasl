<?php

use Illuminate\Support\Facades\Route;

Route::name('vendor.')->group(function () {


    Route::controller('ChannelController')->group(function () {
        Route::get('channels/datatable', 'datatable')->name('channels.datatable');
        Route::get('channels/deletes', 'deletes')->name('channels.deletes');
        Route::get('channels/{id}/logout', 'logout')->name('channels.logout');
        Route::get('channels/{id}/clearData', 'clearData')->name('channels.clearData');
        Route::get('channels/{id}/clearChannel', 'clearChannel')->name('channels.clearChannel');
        Route::post('channels/{id}', 'pushSettings')->name('channels.pushSettings');

    });


    Route::resources([
        'channels' => 'ChannelController'
    ]);
});
