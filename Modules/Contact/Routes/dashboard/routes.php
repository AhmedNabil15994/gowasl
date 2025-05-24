<?php

Route::group(['prefix' => 'contacts'], function () {
    Route::get('/', 'ContactController@index')
    ->name('dashboard.contacts.index');

    Route::get('datatable', 'ContactController@datatable')
    ->name('dashboard.contacts.datatable');

    Route::get('create', 'ContactController@create')
    ->name('dashboard.contacts.create');

    Route::post('/', 'ContactController@store')
    ->name('dashboard.contacts.store');

    Route::get('{id}/edit', 'ContactController@edit')
    ->name('dashboard.contacts.edit');

    Route::put('{id}', 'ContactController@update')
    ->name('dashboard.contacts.update');

    Route::delete('{id}', 'ContactController@destroy')
    ->name('dashboard.contacts.destroy');

    Route::get('deletes', 'ContactController@deletes')
    ->name('dashboard.contacts.deletes');

    Route::get('{id}', 'ContactController@show')
    ->name('dashboard.contacts.show');
});


Route::group(['prefix' => 'numbersGroups'], function () {
    Route::get('/', 'NumbersGroupController@index')
        ->name('dashboard.numbers_groups.index');

    Route::get('datatable', 'NumbersGroupController@datatable')
        ->name('dashboard.numbers_groups.datatable');

    Route::get('create', 'NumbersGroupController@create')
        ->name('dashboard.numbers_groups.create');

    Route::post('/', 'NumbersGroupController@store')
        ->name('dashboard.numbers_groups.store');

    Route::get('{id}/edit', 'NumbersGroupController@edit')
        ->name('dashboard.numbers_groups.edit');

    Route::put('{id}', 'NumbersGroupController@update')
        ->name('dashboard.numbers_groups.update');

    Route::delete('{id}', 'NumbersGroupController@destroy')
        ->name('dashboard.numbers_groups.destroy');

    Route::get('deletes', 'NumbersGroupController@deletes')
        ->name('dashboard.numbers_groups.deletes');

    Route::get('{id}', 'NumbersGroupController@show')
        ->name('dashboard.numbers_groups.show');
});
