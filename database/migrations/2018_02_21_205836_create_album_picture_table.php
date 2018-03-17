<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlbumPictureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('album_pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('album_id')->unsigned();
            $table->foreign('album_id')->references('id')->on('albums')->onDelete('cascade');
            $table->integer('picture_id')->unsigned();
            $table->foreign('picture_id')->references('id')->on('pictures')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->string('visibility',15)->default('public');
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
        Schema::dropIfExists('album_picture');
    }
}
