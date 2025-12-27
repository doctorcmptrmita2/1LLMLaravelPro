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
        Schema::create('rate_limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('period', ['daily', 'monthly']);
            $table->integer('limit_tokens');
            $table->integer('used_tokens')->default(0);
            $table->integer('limit_requests');
            $table->integer('used_requests')->default(0);
            $table->timestamp('reset_at');
            $table->timestamps();
            
            $table->unique(['user_id', 'period']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_limits');
    }
};
