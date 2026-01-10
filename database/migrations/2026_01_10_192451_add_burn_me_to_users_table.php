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
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('burn_me_uuid')->nullable()->unique()->after('default_max_view_limit');
            $table->boolean('burn_me_enabled')->default(false)->after('burn_me_uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['burn_me_uuid', 'burn_me_enabled']);
        });
    }
};
