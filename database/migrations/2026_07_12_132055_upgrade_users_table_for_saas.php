<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_premium')->default(false)->after('password');
            $table->integer('stamina_pts')->default(0)->after('is_premium');
            $table->integer('power_pts')->default(0)->after('stamina_pts');
            $table->integer('intelligence_pts')->default(0)->after('power_pts');
            $table->integer('total_pts')->default(0)->after('intelligence_pts');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_premium', 'stamina_pts', 'power_pts', 'intelligence_pts', 'total_pts']);
        });
    }
};