<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->uuid('token')->unique();
            $table->enum('status', ['pending', 'viewed', 'expired'])->default('pending');
            $table->timestamp('viewed_at')->nullable();
            $table->timestamp('expires_at');
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
