<?php

Route::group(['prefix' => 'bots'], function () {
    Route::get('/', 'BotController@index')
    ->name('dashboard.bots.index');

    Route::get('datatable', 'BotController@datatable')
    ->name('dashboard.bots.datatable');

    Route::get('create', 'BotController@create')
    ->name('dashboard.bots.create');

    Route::post('/', 'BotController@store')
    ->name('dashboard.bots.store');

    Route::get('{id}/edit', 'BotController@edit')
    ->name('dashboard.bots.edit');

    Route::put('{id}', 'BotController@update')
    ->name('dashboard.bots.update');

    Route::delete('{id}', 'BotController@destroy')
    ->name('dashboard.bots.destroy');

    Route::get('deletes', 'BotController@deletes')
    ->name('dashboard.bots.deletes');

    Route::get('{id}', 'BotController@show')
    ->name('dashboard.bots.show');
});
