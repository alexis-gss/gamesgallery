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
    public function up(): void
    {
        Schema::create('pictures', function (Blueprint $table) {
            $table->id()->comment('Id of the picture.');
            $table->index('game_id')->unsigned();
            $table->foreignId('game_id')->references('id')->on('games');
            $table->char('uuid', 36)->nullable()->unique()
                ->comment('Universally Unique Identifier (UUID) of the image.');
            $table->string('label')->comment('Label of the image.');
            $table->boolean('published')->comment('The image is already published.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('pictures');
    }
};
