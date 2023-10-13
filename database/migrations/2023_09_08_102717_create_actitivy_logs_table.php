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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')
                ->comment('Id of the user associated, or nullable for a deleted user.');
            $table->boolean('is_anonymous')->comment('If there is no user connected when action was realised.');
            $table->boolean('is_console')->comment('If the action was realised in console.');
            $table->string('model_class')->comment('Target model.');
            $table->integer('model_id')->comment('Id of the target model.');
            $table->integer('event')->comment('Event of this activity (ActivityLogsEventEnum).');
            $table->json('data')->nullable()->comment('List of changes (old and new values).');
            $table->timestamp('created_at')->comment('The date on which the user was published.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
