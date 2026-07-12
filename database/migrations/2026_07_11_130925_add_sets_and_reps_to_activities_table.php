<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            // Menambahkan kolom sets dan reps setelah kolom distance_km
            $table->integer('workout_sets')->nullable()->after('distance_km');
            $table->integer('workout_reps')->nullable()->after('workout_sets');
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn(['workout_sets', 'workout_reps']);
        });
    }
};