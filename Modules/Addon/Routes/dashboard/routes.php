<?php

Route::group(['prefix' => 'addons'], function () {
    Route::get('/', 'AddonController@index')
    ->name('dashboard.addons.index');

    Route::get('datatable', 'AddonController@datatable')
    ->name('dashboard.addons.datatable');

    Route::get('create', 'AddonController@create')
    ->name('dashboard.addons.create');

    Route::post('/', 'AddonController@store')
    ->name('dashboard.addons.store');

    Route::get('{id}/edit', 'AddonController@edit')
    ->name('dashboard.addons.edit');

    Route::put('{id}', 'AddonController@update')
    ->name('dashboard.addons.update');

    Route::delete('{id}', 'AddonController@destroy')
    ->name('dashboard.addons.destroy');

    Route::get('deletes', 'AddonController@deletes')
    ->name('dashboard.addons.deletes');

    Route::get('{id}', 'AddonController@show')
    ->name('dashboard.addons.show');
});
