<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            // Mengubah tipe data duration_minutes dari INTEGER menjadi DECIMAL agar bisa menyimpan detik pecahan
            $table->decimal('duration_minutes', 8, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->integer('duration_minutes')->change();
        });
    }
};