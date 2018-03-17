<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('image_ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('picture_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->char('rate', 1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('picture_id')->references('id')->on('pictures');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_ratings');
    }
}
