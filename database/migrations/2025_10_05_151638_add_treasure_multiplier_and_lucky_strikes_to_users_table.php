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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('treasure_multiplier_level')->default(0)->after('auto_earning_level');
            $table->integer('lucky_strikes_level')->default(0)->after('treasure_multiplier_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['treasure_multiplier_level', 'lucky_strikes_level']);
        });
    }
};
