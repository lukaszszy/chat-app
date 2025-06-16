<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('email', 500)->nullable(false)->default("NO_DATA");
            $table->string('url', 100)->unique();
            $table->boolean('linkClicked')->nullable(false)->default(false);
            $table->timestamps();
        });

        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->string('url', 100)->unique();
            $table->enum('gender', ['male', 'female', 'NoComment', 'NO_DATA'])->default("NO_DATA");
            $table->integer('age')->nullable(false)->default(0);
            $table->string('discipline', 500)->nullable(false)->default("NO_DATA");
            $table->string('title', 500)->nullable(false)->default("NO_DATA");
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('interview_id');
            $table->string('content', 1000)->nullable(false)->default("NO_DATA");
            $table->boolean('is_bot')->nullable(false)->default(false);
            $table->string('finished_by_boot', 500)->nullable(false)->default(false);
            $table->timestamps();

            $table->foreign('interview_id')->references('id')->on('interviews')->onDelete('cascade');
        });

        Schema::create('quality_surveys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('interview_id');
            $table->string('q1', 100)->nullable();
            $table->string('q2', 100)->nullable();
            $table->string('q3', 100)->nullable();
            $table->string('q4', 500)->nullable();
            $table->string('q5', 1000)->nullable();
            $table->timestamps();

            $table->foreign('interview_id')->references('id')->on('interviews')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quality_surveys', function (Blueprint $table) {
            if (Schema::hasColumn('quality_surveys', 'interview_id')) {
                $table->dropForeign(['interview_id']);
            }    
        });

        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'interview_id')) {
                $table->dropForeign(['interview_id']);
            }
        });

        Schema::dropIfExists('quality_surveys');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('interviews');
        Schema::dropIfExists('links');
    }
};
