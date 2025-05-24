<?php

Route::group(['prefix' => 'messages'], function () {
    Route::get('/', 'MessageController@index')
    ->name('dashboard.messages.index');

    Route::get('datatable', 'MessageController@datatable')
    ->name('dashboard.messages.datatable');

    Route::get('create', 'MessageController@create')
    ->name('dashboard.messages.create');

    Route::post('/', 'MessageController@store')
    ->name('dashboard.messages.store');

    Route::get('{id}/edit', 'MessageController@edit')
    ->name('dashboard.messages.edit');

    Route::put('{id}', 'MessageController@update')
    ->name('dashboard.messages.update');

    Route::delete('{id}', 'MessageController@destroy')
    ->name('dashboard.messages.destroy');

    Route::get('deletes', 'MessageController@deletes')
    ->name('dashboard.messages.deletes');

    Route::get('{id}', 'MessageController@show')
    ->name('dashboard.messages.show');

    Route::get('{id}/getChannelData', 'MessageController@getChannelData')
        ->name('dashboard.messages.getChannelData');

    Route::get('create}/getContactDetails', 'MessageController@getContactDetails')
        ->name('dashboard.messages.getContactDetails');


    Route::post('/uploadFile', 'MessageController@uploadFile')
        ->name('dashboard.messages.uploadFile');

});

// Bulk Messages
Route::group(['prefix' => 'bulk_messages'], function () {

    Route::get('/', 'BulkMessageController@index')
        ->name('dashboard.bulk_messages.index');

    Route::get('datatable', 'BulkMessageController@datatable')
        ->name('dashboard.bulk_messages.datatable');

    Route::get('create', 'BulkMessageController@create')
        ->name('dashboard.bulk_messages.create');

    Route::post('/store', 'BulkMessageController@store')
        ->name('dashboard.bulk_messages.store');

    Route::get('{id}', 'BulkMessageController@show')
        ->name('dashboard.bulk_messages.show');

    Route::delete('{id}', 'BulkMessageController@destroy')
        ->name('dashboard.bulk_messages.destroy');

    Route::get('deletes', 'BulkMessageController@deletes')
        ->name('dashboard.bulk_messages.deletes');
});

Route::group(['prefix' => 'decision_messages'], function () {

    Route::get('/', 'DecisionMessageController@index')
        ->name('dashboard.decision_messages.index');

    Route::get('datatable', 'DecisionMessageController@datatable')
        ->name('dashboard.decision_messages.datatable');

    Route::get('create', 'DecisionMessageController@create')
        ->name('dashboard.decision_messages.create');

    Route::post('/store', 'DecisionMessageController@store')
        ->name('dashboard.decision_messages.store');

    Route::get('{id}', 'DecisionMessageController@show')
        ->name('dashboard.decision_messages.show');

    Route::delete('{id}', 'DecisionMessageController@destroy')
        ->name('dashboard.decision_messages.destroy');

    Route::get('deletes', 'DecisionMessageController@deletes')
        ->name('dashboard.decision_messages.deletes');
});
