<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDinnerMealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dinner_meal', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->enum('type',['Main', 'Side', 'Sweet']);
            $table->integer('qty')->default(1);
            $table->unsignedBigInteger('dinner_id');
            $table->unsignedBigInteger('meal_id');

            $table->foreign('dinner_id')->references('id')->on('dinners')->onDelete('cascade');
            $table->foreign('meal_id')->references('id')->on('meals')->onDelete('cascade');
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
        Schema::dropIfExists('dinner_meal');
    }
}