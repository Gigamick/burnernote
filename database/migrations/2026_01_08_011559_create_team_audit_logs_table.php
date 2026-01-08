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
        Schema::create('team_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action'); // note_created, note_viewed, note_expired, member_invited, member_joined, member_removed
            $table->json('metadata')->nullable(); // recipient_email, note_token, ip_address, user_agent, etc.
            $table->timestamps();
            $table->index(['team_id', 'created_at']);
            $table->index(['team_id', 'action']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_audit_logs');
    }
};
