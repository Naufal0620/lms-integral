<?php

use App\Models\Lesson;
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
        Lesson::all()->each(function ($lesson) {
            // Replace specific math terms used in current lessons
            $content = $lesson->content;
            
            // Replaces: $C$ -> \(C\), $a$ -> \(a\), $b$ -> \(b\), $u$ -> \(u\), etc.
            // Using a simple regex to replace $...$ with \(...\)
            // But we must NOT replace $$...$$
            
            // Strategy: 
            // 1. Temporarily replace $$ with a placeholder
            // 2. Replace single $...$ with \(...\)
            // 3. Revert $$ placeholder
            
            $content = str_replace('$$', '##DISPLAY_MATH##', $content);
            $content = preg_replace('/\$([^\$]+)\$/', '\($1\)', $content);
            $content = str_replace('##DISPLAY_MATH##', '$$', $content);
            
            if ($content !== $lesson->content) {
                $lesson->content = $content;
                $lesson->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Lesson::all()->each(function ($lesson) {
            // Revert: \(...\) -> $...$
            $content = $lesson->content;
            $content = str_replace(['\(', '\)'], '$', $content);
            
            if ($content !== $lesson->content) {
                $lesson->content = $content;
                $lesson->save();
            }
        });
    }
};
