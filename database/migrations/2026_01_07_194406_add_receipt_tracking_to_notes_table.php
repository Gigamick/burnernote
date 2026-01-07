<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->uuid('receipt_token')->nullable()->after('token');
            $table->index('receipt_token');
        });
    }

    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropIndex(['receipt_token']);
            $table->dropColumn('receipt_token');
        });
    }
};
