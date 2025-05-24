<?php

use Modules\User\Entities\User;
use Modules\Order\Entities\Order;
use Modules\Course\Entities\Course;
use Modules\Trainer\Entities\Trainer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_courses', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 9, 3);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('expired_date')->nullable();
            $table->integer('period')->nullable();
            $table->integer('duration_type')->nullable();
            $table->text('settings')->nullable();
            $table->foreignIdFor(\Modules\Package\Entities\Package::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(Order::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('order_courses');
    }
}
