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
        Schema::table('magic_link_tokens', function (Blueprint $table) {
            $table->boolean('is_registration')->default(false)->after('ip_address');
        });
    }

    public function down(): void
    {
        Schema::table('magic_link_tokens', function (Blueprint $table) {
            $table->dropColumn('is_registration');
        });
    }
};
