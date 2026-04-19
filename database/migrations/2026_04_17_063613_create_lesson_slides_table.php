<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lesson_slides', function (Blueprint $col) {
            $col->id();
            $col->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $col->string('title')->nullable();
            $col->text('content')->nullable();
            $col->enum('type', ['content', 'quiz'])->default('content');
            $col->integer('order')->default(1);
            $col->timestamps();
        });

        // Add quiz relation to questions table
        Schema::table('questions', function (Blueprint $col) {
            $col->foreignId('lesson_slide_id')->nullable()->constrained()->onDelete('cascade');
            $col->foreignId('quiz_id')->nullable()->change(); // Make quiz_id nullable for lesson-specific questions
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_slides');
    }
};
