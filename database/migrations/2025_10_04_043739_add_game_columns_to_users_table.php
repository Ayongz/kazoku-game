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
            // Player Economy
            $table->unsignedBigInteger('money_earned')->default(0);
            
            // Game Attempts
            $table->unsignedSmallInteger('attempts')->default(1);
            $table->timestamp('last_attempt_at')->nullable();
            
            // Steal Ability
            $table->unsignedSmallInteger('steal_level')->default(0); // 0 = not purchased, 1+ = upgrade level
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['money_earned', 'attempts', 'last_attempt_at', 'steal_level']);
        });
    }
};
