<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 80);
            $table->string('fantasy_name', 80);
            $table->string('doc_number',18);
            $table->string('city');
            $table->string('phone', 15);
            $table->string('email');
            $table->boolean('has_contract')->default(false);
            $table->boolean('has_restriction')->default(false);
            $table->text('restriction_anotation')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
