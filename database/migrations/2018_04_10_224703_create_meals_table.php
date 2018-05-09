<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bellies');
            $table->text('description');
            $table->text('photo')->nullable();
            $table->dateTime('expiration_date')->nullable();
            $table->integer('stage')->default(0);
            $table->integer('pick_up_location_id')->unsigned()->nullable();
            $table->foreign('pick_up_location_id')->references('id')->on('locations')->onDelete('cascade');
            $table->integer('kitchen_id')->unsigned()->nullable();
            $table->foreign('kitchen_id')->references('id')->on('kitchens')->onDelete('cascade');
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
        Schema::dropIfExists('meals');
    }
}
