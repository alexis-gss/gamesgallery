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
        Schema::create('ranks', function (Blueprint $table) {
            $table->id()->comment('Id of the rank.');
            $table->foreignId('game_id')->comment('Game associated to the rank.')
                ->constrained('games')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('rank')->comment('Rank of the game.');
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
        Schema::dropIfExists('ranks');
    }
};
