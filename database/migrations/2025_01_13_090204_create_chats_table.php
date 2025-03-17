<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id', 500)->unique();
            $table->string('email', 500)->nullable(false)->default("NoInfo");
            $table->enum('gender', ['male', 'female', 'NoComment', 'NoInfo'])->default("NoInfo");
            $table->integer('age')->nullable(false)->default(0);
            $table->string('discipline', 500)->nullable(false)->default("NoInfo");
            $table->string('title', 500)->nullable(false)->default("NoInfo");
            $table->boolean('survFinished')->nullable(false)->default(false);
            $table->boolean('chatFinished')->nullable(false)->default(false);
            $table->boolean('postsurFinished')->nullable(false)->default(false);
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_id');
            $table->string('content', 1000)->nullable(false);
            $table->boolean('is_bot')->nullable(false)->default(false);
            $table->string('finished_by_boot', 500)->nullable();
            $table->timestamps();

            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');
        });

        Schema::create('quality_surveys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_id');
            $table->string('q1', 100)->nullable();
            $table->string('q2', 100)->nullable();
            $table->string('q3', 100)->nullable();
            $table->string('q4', 500)->nullable();
            $table->string('q5', 1000)->nullable();
            $table->timestamps();

            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quality_surveys', function (Blueprint $table) {
            if (Schema::hasColumn('quality_surveys', 'chat_id')) {
                $table->dropForeign(['chat_id']);
                $table->dropColumn('chat_id');
            }    
        });

        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'chat_id')) {
                $table->dropForeign(['chat_id']);
                $table->dropColumn('chat_id');
            }
        });

        Schema::dropIfExists('quality_surveys');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('chats');
    }
};
