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
            $table->string('name')->comment('Name of the user.');
            $table->string('slug')->comment('Slugify the name of the user.');
            $table->string('email')->unique()->comment('Email of the user that is unique.');
            $table->string('picture')->comment('Picture associated to this user.');
            $table->string('picture_alt')->comment('Alt attribute of the image.');
            $table->string('password')->comment('Encrypted password of the user.');
            $table->boolean('role')->comment('Role of the user who defines the rights/access.');
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
        Schema::dropIfExists('users');
    }
}
