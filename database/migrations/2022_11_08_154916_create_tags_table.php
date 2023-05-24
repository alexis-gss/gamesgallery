<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Nom du tag qui sera unique.');
            $table->string('slug')->unique()->comment('Slugify the name of the tag.');
            $table->boolean('published')->comment('The tag is published or not');
            $table->timestamp('published_at')->nullable()->comment('The date on which the tag was published.');
            $table->integer('order')->comment('Order of this tag.');
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
        Schema::dropIfExists('tags');
    }
}
