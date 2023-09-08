<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Name of the folder.');
            $table->string('slug')->unique()->comment('Slugify the name of the folder.');
            $table->string('color')->comment('Color of the folder.');
            $table->boolean('published')->comment('The folder is published or not.');
            $table->timestamp('published_at')->nullable()->comment('The date on which the folder was published.');
            $table->integer('order')->comment('Order of this folder.');
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
        Schema::dropIfExists('folders');
    }
};
