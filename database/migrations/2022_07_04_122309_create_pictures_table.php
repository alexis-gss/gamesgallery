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
            $table->char('uuid', 36)->nullable()->unique()
                ->comment('Universally Unique Identifier (UUID) of the picture.');
            $table->string('label')->comment('Label of the picture.');
            $table->foreignId('game_id')->comment('Game associated to the picture.')
                ->constrained('games')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('published')->comment('The picture is already published.');
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
