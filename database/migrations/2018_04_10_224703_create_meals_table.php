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
            $table->text('comment');
            $table->text('photo')->nullable();
            $table->dateTime('expiration_date');
            $table->integer('stage')->default(0);
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
        Schema::dropIfExists('meals');
    }
}
