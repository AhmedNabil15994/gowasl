<?php

Route::group(['prefix' => 'packages'], function () {
    Route::get('/', 'PackageController@index')
    ->name('dashboard.packages.index');

    Route::get('datatable', 'PackageController@datatable')
    ->name('dashboard.packages.datatable');

    Route::get('create', 'PackageController@create')
    ->name('dashboard.packages.create');

    Route::post('/', 'PackageController@store')
    ->name('dashboard.packages.store');

    Route::get('{id}/edit', 'PackageController@edit')
    ->name('dashboard.packages.edit');

    Route::put('{id}', 'PackageController@update')
    ->name('dashboard.packages.update');

    Route::delete('{id}', 'PackageController@destroy')
    ->name('dashboard.packages.destroy');

    Route::get('deletes', 'PackageController@deletes')
    ->name('dashboard.packages.deletes');

    Route::get('{id}', 'PackageController@show')
    ->name('dashboard.packages.show');
});
