<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('session_states', function (Blueprint $table) {
            $table->uuid('session_id')->primary();
            $table->string('restaurant_name')->nullable();
            $table->string('current_step')->default('awaiting_greeting');
            $table->string('temp_product_name')->nullable();
            $table->integer('temp_quantity')->nullable();
            $table->json('interaction_history')->nullable();
            $table->foreignId('last_chosen_product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->timestamp('last_interaction')->nullable();
            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnDelete();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_states');
    }
};
