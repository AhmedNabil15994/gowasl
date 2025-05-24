<?php

Route::group(['prefix' => 'messages'], function () {
    Route::get('/', 'MessageController@index')
    ->name('vendor.messages.index');

    Route::get('datatable', 'MessageController@datatable')
    ->name('vendor.messages.datatable');

    Route::get('create', 'MessageController@create')
    ->name('vendor.messages.create');

    Route::post('/', 'MessageController@store')
    ->name('vendor.messages.store');

    Route::get('{id}/edit', 'MessageController@edit')
    ->name('vendor.messages.edit');

    Route::put('{id}', 'MessageController@update')
    ->name('vendor.messages.update');

    Route::delete('{id}', 'MessageController@destroy')
    ->name('vendor.messages.destroy');

    Route::get('deletes', 'MessageController@deletes')
    ->name('vendor.messages.deletes');

    Route::get('{id}', 'MessageController@show')
    ->name('vendor.messages.show');

    Route::get('{id}/getChannelData', 'MessageController@getChannelData')
        ->name('vendor.messages.getChannelData');

    Route::get('create}/getContactDetails', 'MessageController@getContactDetails')
        ->name('vendor.messages.getContactDetails');


    Route::post('/uploadFile', 'MessageController@uploadFile')
        ->name('vendor.messages.uploadFile');

});

// Bulk Messages
Route::group(['prefix' => 'bulk_messages'], function () {

    Route::get('/', 'BulkMessageController@index')
        ->name('vendor.bulk_messages.index');

    Route::get('datatable', 'BulkMessageController@datatable')
        ->name('vendor.bulk_messages.datatable');

    Route::get('create', 'BulkMessageController@create')
        ->name('vendor.bulk_messages.create');

    Route::post('/store', 'BulkMessageController@store')
        ->name('vendor.bulk_messages.store');

    Route::get('{id}', 'BulkMessageController@show')
        ->name('vendor.bulk_messages.show');

    Route::delete('{id}', 'BulkMessageController@destroy')
        ->name('vendor.bulk_messages.destroy');

    Route::get('deletes', 'BulkMessageController@deletes')
        ->name('vendor.bulk_messages.deletes');
});

Route::group(['prefix' => 'decision_messages'], function () {

    Route::get('/', 'DecisionMessageController@index')
        ->name('vendor.decision_messages.index');

    Route::get('datatable', 'DecisionMessageController@datatable')
        ->name('vendor.decision_messages.datatable');

    Route::get('create', 'DecisionMessageController@create')
        ->name('vendor.decision_messages.create');

    Route::post('/store', 'DecisionMessageController@store')
        ->name('vendor.decision_messages.store');

    Route::get('{id}', 'DecisionMessageController@show')
        ->name('vendor.decision_messages.show');

    Route::delete('{id}', 'DecisionMessageController@destroy')
        ->name('vendor.decision_messages.destroy');

    Route::get('deletes', 'DecisionMessageController@deletes')
        ->name('vendor.decision_messages.deletes');
});
