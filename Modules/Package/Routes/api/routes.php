<?php

Route::group(['prefix' => 'packages'], function () {
    Route::get('/', 'PackageController@index')
    ->name('api.packages.index');


    Route::get('{id}', 'PackageController@show')
    ->name('dashboard.packages.show');
});
