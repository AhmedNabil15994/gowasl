<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBulkMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_messages', function (Blueprint $table) {
            $table->id();
            $table->text('message_id');
            $table->integer('channel_id');
            $table->integer('interval');
            $table->string('message_type');
            $table->longText('message_data');
            $table->integer('sending_later');
            $table->dateTime('sending_date');
            $table->string('bulk_flag');
            $table->longText('bulk_contacts');
            $table->integer('status');
            $table->longText('queue_data')->nullable();
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
        Schema::dropIfExists('bulk_messages');
    }
}
