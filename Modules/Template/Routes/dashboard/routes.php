<?php

Route::group(['prefix' => 'templates'], function () {
    Route::get('/', 'TemplateController@index')
    ->name('dashboard.templates.index');

    Route::get('datatable', 'TemplateController@datatable')
    ->name('dashboard.templates.datatable');

    Route::get('create', 'TemplateController@create')
    ->name('dashboard.templates.create');

    Route::post('/', 'TemplateController@store')
    ->name('dashboard.templates.store');

    Route::get('{id}/edit', 'TemplateController@edit')
    ->name('dashboard.templates.edit');

    Route::put('{id}', 'TemplateController@update')
    ->name('dashboard.templates.update');

    Route::delete('{id}', 'TemplateController@destroy')
    ->name('dashboard.templates.destroy');

    Route::get('deletes', 'TemplateController@deletes')
    ->name('dashboard.templates.deletes');

    Route::get('{id}', 'TemplateController@show')
    ->name('dashboard.templates.show');
});
