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
            $table->bigIncrements('id');
            $table->index('game_id')->unsigned();
            $table->foreignId('game_id')->references('id')->on('games');
            $table->char('uuid', 36)->nullable()->unique();
            $table->string('label')->comment('Label of the image.');
            $table->string('type', 20)->comment('Type of the image (jpeg, jpg, png).');
            $table->boolean('published')->comment('The image is already published.');
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
        Schema::dropIfExists('pictures');
    }
}
