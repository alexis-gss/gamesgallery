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
            $table->foreignId('folder_id')->nullable()->references('id')->on('folders');
            $table->string('name')->comment('Name of the game.');
            $table->string('slug')->unique()->comment('Slugify the name of the game.');
            $table->text('pictures')->nullable()->comment('Json who contains pictures, it can be also null.');
            $table->string('pictures_alt')->comment('Alt attribute of the images.');
            $table->integer('order')->default(1);
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
