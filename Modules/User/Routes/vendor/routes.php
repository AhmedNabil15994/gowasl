<?php

use Illuminate\Support\Facades\Route;

Route::name('vendor.')->group(function () {


    Route::controller('UserController')->group(function () {
        Route::get('users/datatable', 'datatable')->name('users.datatable');
        Route::get('users/deletes', 'deletes')->name('users.deletes');
    });


    Route::resources([
        'users'  => 'UserController',
    ]);
});
