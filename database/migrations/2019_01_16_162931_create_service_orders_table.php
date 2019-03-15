<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('os_number', 10)->nullable();
            $table->integer('customer_id');
            $table->string('contact')->nullable();
            $table->integer('equipment_id');
            $table->string('serial')->nullable();
            $table->date('entrance_date');
            $table->integer('entrance_movement_id');
            $table->boolean('factory')->default(0);
            $table->text('documents')->nullable();
            $table->text('fault')->nullable();
            $table->date('exit_date')->nullable();
            $table->integer('exit_movement_id')->nullable();
            $table->boolean('status')->default(1);
            $table->integer('situation_id');
            $table->integer('user_id');
            $table->longText('budget')->nullable();
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
        Schema::dropIfExists('service_orders');
    }
}
