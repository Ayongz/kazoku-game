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
            $table->integer('gambling_level')->default(1);
            $table->integer('gambling_exp')->default(0);
            $table->integer('gambling_attempts_today')->default(0);
            $table->timestamp('last_gambling_reset')->nullable();
            $table->integer('rare_treasures')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'gambling_level',
                'gambling_exp', 
                'gambling_attempts_today',
                'last_gambling_reset',
                'rare_treasures'
            ]);
        });
    }
};
