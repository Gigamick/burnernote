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
        Schema::table('notes', function (Blueprint $table) {
            $table->foreignId('recipient_user_id')->nullable()->constrained('users')->nullOnDelete()->after('team_id');
            $table->boolean('is_burn_me')->default(false)->after('recipient_user_id');
            $table->timestamp('read_at')->nullable()->after('is_burn_me');
            $table->text('encrypted_client_key')->nullable()->after('read_at');

            $table->index(['recipient_user_id', 'is_burn_me', 'read_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropIndex(['recipient_user_id', 'is_burn_me', 'read_at']);
            $table->dropForeign(['recipient_user_id']);
            $table->dropColumn(['recipient_user_id', 'is_burn_me', 'read_at', 'encrypted_client_key']);
        });
    }
};
