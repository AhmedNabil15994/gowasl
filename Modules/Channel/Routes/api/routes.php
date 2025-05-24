<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'channels/'], function () {

    Route::group(['prefix' => 'instances/' ], function () {
        Route::get('qr', 'InstancesController@qr')->name('api.channels.instances.qr');
        Route::get('status', 'InstancesController@status')->name('api.channels.instances.status');
        Route::post('disconnect', 'InstancesController@disconnect')->name('api.channels.instances.disconnect');
        Route::post('clearInstance', 'InstancesController@clearInstance')->name('api.channels.instances.clearInstance');
        Route::post('clearInstanceData', 'InstancesController@clearInstanceData')->name('api.channels.instances.clearInstanceData');
    });

    Route::group(['prefix' => 'messages/' ,'middleware' => \Modules\Channel\Http\Middleware\ChannelAvailability::class], function () {
        Route::post('sendMessage', 'MessagesController@sendMessage')->name('api.channels.messages.sendMessage');
        Route::post('sendImage', 'MessagesController@sendImage')->name('api.channels.messages.sendImage');
        Route::post('sendVideo', 'MessagesController@sendVideo')->name('api.channels.messages.sendVideo');
        Route::post('sendFile', 'MessagesController@sendFile')->name('api.channels.messages.sendFile');
        Route::post('sendAudio', 'MessagesController@sendAudio')->name('api.channels.messages.sendAudio');
        Route::post('sendLink', 'MessagesController@sendLink')->name('api.channels.messages.sendLink');
        Route::post('sendSticker', 'MessagesController@sendSticker')->name('api.channels.messages.sendSticker');
        Route::post('sendGif', 'MessagesController@sendGif')->name('api.channels.messages.sendGif');

        Route::post('sendContact', 'MessagesController@sendContact')->name('api.channels.messages.sendContact');
        Route::post('sendLocation', 'MessagesController@sendLocation')->name('api.channels.messages.sendLocation');
        Route::post('sendMention', 'MessagesController@sendMention')->name('api.channels.messages.sendMention');
        Route::post('sendReaction', 'MessagesController@sendReaction')->name('api.channels.messages.sendReaction');


        Route::post('sendButtons', 'MessagesController@sendButtons')->name('api.channels.messages.sendButtons');
        Route::post('sendButtonsTemplate', 'MessagesController@sendButtonsTemplate')->name('api.channels.messages.sendButtonsTemplate');
        Route::post('sendListMessage', 'MessagesController@sendListMessage')->name('api.channels.messages.sendListMessage');
        Route::post('sendPoll', 'MessagesController@sendPoll')->name('api.channels.messages.sendPoll');
        Route::post('sendBulkMessage', 'MessagesController@sendBulkMessage')->name('api.channels.messages.sendBulkMessage');
        Route::post('sendDecisionMessage', 'MessagesController@sendDecisionMessage')->name('api.channels.messages.sendDecisionMessage');

    });
});
