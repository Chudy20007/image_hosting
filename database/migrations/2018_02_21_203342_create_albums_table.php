<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('title', 50);
            $table->string('title_photo', 50);
            $table->string('description', 50);         
            $table->foreign('user_id')->references('id')->on('users');
            $table->boolean('is_active')->default(true);
            $table->boolean('active_ratings')->default(true);
            $table->string('visibility', 10);
            $table->string('upload_link');
            $table->boolean('active_comments')->default(true);
            $table->integer('visited_count')->unsigned()->default(0);
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
        Schema::dropIfExists('albums');
    }
}
