<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pictures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('title', 50);
            $table->string('source', 120);
            $table->string('description');
            $table->boolean('is_active')->default(true);
            $table->boolean('active_ratings')->default(true);
            $table->string('visibility', 10);
            $table->boolean('active_comments')->default(true);
            $table->integer('visited_count')->unsigned()->default(0);
            $table->string('uploadLink', 120)->nullable($value = true);
            $table->timestamps();
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
        if (Schema::hasColumn('updated_at', 'created_at')) {

            $table->dropColumn(['updated_at', 'created_at']);
        }

        Schema::dropIfExists('pictures');

    }
}
