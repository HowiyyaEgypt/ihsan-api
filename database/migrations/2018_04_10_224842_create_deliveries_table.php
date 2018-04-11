<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->text('comment');
            $table->text('photo')->nullable();
            $table->dateTime('pickup_date');
            $table->dateTime('delivery_date');
            $table->integer('meal_id')->unsigned();
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
            $table->integer('pick_up_location_id')->unsigned()->nullable();
            $table->foreign('pick_up_location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->integer('drop_location_id')->unsigned()->nullable();
            $table->foreign('drop_location_id')->references('id')->on('locations')->onDelete('cascade');
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
        Schema::dropIfExists('deliveries');
    }
}
