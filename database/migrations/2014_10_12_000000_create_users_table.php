<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->text('name')->comment('Name of the user.');
            $table->text('slug')->comment('Slugify of the name of the user.');
            $table->text('email')->unique()->comment('Email of the user that is unique.');
            $table->text('picture')->nullable()->comment('Picture associated to this user.');
            $table->text('picture_alt')->default("No image")->comment('Alt attribute of the image.');
            $table->text('password')->comment('Encrypted password of the user.');
            $table->boolean('role')->default(0)->comment('Role of the user who defines the rights/access.');
            $table->integer('order')->default(1)->comment('Order of this folder, which is 1 by default.');
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
        Schema::dropIfExists('users');
    }
}
