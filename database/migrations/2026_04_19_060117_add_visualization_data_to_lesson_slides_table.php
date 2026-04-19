<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lesson_slides', function (Blueprint $table) {
            $table->json('visualization_data')->nullable()->after('content');
            $table->string('type')->default('content')->change(); // Change to string for more flexibility or broader enum
        });
    }

    public function down(): void
    {
        Schema::table('lesson_slides', function (Blueprint $table) {
            $table->dropColumn('visualization_data');
        });
    }
};
