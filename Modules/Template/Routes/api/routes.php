<?php

Route::group(['prefix' => 'templates'], function () {
    Route::get('/', 'TemplateController@index')
    ->name('api.templates.index');


    Route::get('{id}', 'TemplateController@show')
    ->name('dashboard.templates.show');
});
