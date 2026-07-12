<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            // Menambahkan kolom jarak desimal setelah kolom intensity_score
            $table->decimal('distance_km', 5, 2)->nullable()->after('intensity_score');
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('distance_km');
        });
    }
};