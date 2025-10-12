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
        Schema::create('player_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('action_type', [
                'treasure_open',
                'rare_treasure_open', 
                'random_box_open',
                'gambling_dice',
                'gambling_card',
                'treasure_fusion'
            ]);
            $table->string('description');
            $table->decimal('money_change', 15, 2)->default(0); // Can be positive or negative
            $table->integer('treasure_change')->default(0); // Treasure gained/lost
            $table->integer('rare_treasure_change')->default(0); // Rare treasure gained/lost
            $table->integer('random_box_change')->default(0); // Random boxes gained/lost
            $table->integer('experience_gained')->default(0);
            $table->json('additional_data')->nullable(); // For storing extra info like class bonuses, night mode effects, etc.
            $table->boolean('is_success')->default(true); // Track if action was successful or resulted in loss
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index(['user_id', 'created_at']);
            $table->index(['user_id', 'action_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_logs');
    }
};
