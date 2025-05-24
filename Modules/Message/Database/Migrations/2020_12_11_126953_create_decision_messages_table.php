<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDecisionMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('decision_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('channel_id');
            $table->longText('message_data');
            $table->string('whatsapp');
            $table->dateTime('send_at');
            $table->longText('queue_data')->nullable();
            $table->integer('is_replied');
            $table->integer('is_sent');
            $table->integer('status');
            $table->string('job_queue_id')->nullable();
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
        Schema::dropIfExists('decision_messages');
    }
}
