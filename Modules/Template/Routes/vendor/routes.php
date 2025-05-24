<?php

Route::group(['prefix' => 'templates'], function () {
    Route::get('/', 'TemplateController@index')
    ->name('vendor.templates.index');

    Route::get('datatable', 'TemplateController@datatable')
    ->name('vendor.templates.datatable');

    Route::get('create', 'TemplateController@create')
    ->name('vendor.templates.create');

    Route::post('/', 'TemplateController@store')
    ->name('vendor.templates.store');

    Route::get('{id}/edit', 'TemplateController@edit')
    ->name('vendor.templates.edit');

    Route::put('{id}', 'TemplateController@update')
    ->name('vendor.templates.update');

    Route::delete('{id}', 'TemplateController@destroy')
    ->name('vendor.templates.destroy');

    Route::get('deletes', 'TemplateController@deletes')
    ->name('vendor.templates.deletes');

    Route::get('{id}', 'TemplateController@show')
    ->name('vendor.templates.show');
});
