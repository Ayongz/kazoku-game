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
            // Class system columns
            $table->string('selected_class')->nullable()->after('randombox');
            $table->boolean('has_advanced_class')->default(false)->after('selected_class');
            $table->timestamp('class_selected_at')->nullable()->after('has_advanced_class');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['selected_class', 'has_advanced_class', 'class_selected_at']);
        });
    }
};
