<?php

Route::group(['prefix' => 'bots'], function () {
    Route::get('/', 'BotController@index')
    ->name('vendor.bots.index');

    Route::get('datatable', 'BotController@datatable')
    ->name('vendor.bots.datatable');

    Route::get('create', 'BotController@create')
    ->name('vendor.bots.create');

    Route::post('/', 'BotController@store')
    ->name('vendor.bots.store');

    Route::get('{id}/edit', 'BotController@edit')
    ->name('vendor.bots.edit');

    Route::put('{id}', 'BotController@update')
    ->name('vendor.bots.update');

    Route::delete('{id}', 'BotController@destroy')
    ->name('vendor.bots.destroy');

    Route::get('deletes', 'BotController@deletes')
    ->name('vendor.bots.deletes');

    Route::get('{id}', 'BotController@show')
    ->name('vendor.bots.show');
});
