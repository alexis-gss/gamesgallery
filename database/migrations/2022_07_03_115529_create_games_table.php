<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->index('folder_id')->unsigned();
            $table->foreignId('folder_id')->references('id')->on('folders');
            $table->string('name')->comment('Name of the game.');
            $table->string('slug')->unique()->comment('Slugify the name of the game.');
            $table->json('pictures')->nullable()->comment('Json who contains pictures.');
            $table->string('pictures_alt')->comment('Alt attribute of the images.');
            $table->string('pictures_title')->comment('Title attribute of the images.');
            $table->boolean('status')->comment('The game is published or not');
            $table->integer('order')->comment('Order of this game.');
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
        Schema::dropIfExists('games');
    }
}
