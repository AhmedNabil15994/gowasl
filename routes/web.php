<?php


// Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
//      \UniSharp\LaravelFilemanager\Lfm::routes();
//  });
Route::group(['prefix' => '/webhooks'] ,function(){
    Route::webhooks('/messages-webhook','default');
});
