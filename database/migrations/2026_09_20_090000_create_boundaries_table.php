<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boundaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->uuid('client_uuid')->unique();
            $table->string('name', 120);
            $table->text('notes')->nullable();
            $table->string('capture_mode', 16); // manual or recorded
            $table->json('points');
            $table->timestamp('recorded_at');
            $table->timestamps();
            $table->index(['user_id', 'recorded_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boundaries');
    }
};
