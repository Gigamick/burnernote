<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->index('token');
            $table->index('user_id');
            $table->index('expiry_date');
        });
    }

    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropIndex(['token']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['expiry_date']);
        });
    }
};
