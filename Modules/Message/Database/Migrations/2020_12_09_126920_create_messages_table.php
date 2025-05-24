<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('message_id');
            $table->integer('channel_id');
            $table->longText('body');
            $table->text('author');
            $table->text('fromMe');
            $table->text('chatName');
            $table->text('pushName');
            $table->text('remoteJid');
            $table->text('messageType');
            $table->text('deviceSentFrom');
            $table->text('timeFormatted');
            $table->text('time');
            $table->integer('status');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
