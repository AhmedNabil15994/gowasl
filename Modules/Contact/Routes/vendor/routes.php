<?php

Route::group(['prefix' => 'contacts'], function () {
    Route::get('/', 'ContactController@index')
    ->name('vendor.contacts.index');

    Route::get('datatable', 'ContactController@datatable')
    ->name('vendor.contacts.datatable');

    Route::get('create', 'ContactController@create')
    ->name('vendor.contacts.create');

    Route::post('/', 'ContactController@store')
    ->name('vendor.contacts.store');

    Route::get('{id}/edit', 'ContactController@edit')
    ->name('vendor.contacts.edit');

    Route::put('{id}', 'ContactController@update')
    ->name('vendor.contacts.update');

    Route::delete('{id}', 'ContactController@destroy')
    ->name('vendor.contacts.destroy');

    Route::get('deletes', 'ContactController@deletes')
    ->name('vendor.contacts.deletes');

    Route::get('{id}', 'ContactController@show')
    ->name('vendor.contacts.show');
});


Route::group(['prefix' => 'numbersGroups'], function () {
    Route::get('/', 'NumbersGroupController@index')
        ->name('vendor.numbers_groups.index');

    Route::get('datatable', 'NumbersGroupController@datatable')
        ->name('vendor.numbers_groups.datatable');

    Route::get('create', 'NumbersGroupController@create')
        ->name('vendor.numbers_groups.create');

    Route::post('/', 'NumbersGroupController@store')
        ->name('vendor.numbers_groups.store');

    Route::get('{id}/edit', 'NumbersGroupController@edit')
        ->name('vendor.numbers_groups.edit');

    Route::put('{id}', 'NumbersGroupController@update')
        ->name('vendor.numbers_groups.update');

    Route::delete('{id}', 'NumbersGroupController@destroy')
        ->name('vendor.numbers_groups.destroy');

    Route::get('deletes', 'NumbersGroupController@deletes')
        ->name('vendor.numbers_groups.deletes');

    Route::get('{id}', 'NumbersGroupController@show')
        ->name('vendor.numbers_groups.show');
});
