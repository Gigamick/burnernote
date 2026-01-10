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
            $table->enum('account_mode', ['individual', 'team'])->nullable()->after('profile_completed');
            $table->unsignedInteger('default_max_expiry_days')->default(30)->after('account_mode');
            $table->unsignedInteger('default_min_expiry_days')->default(1)->after('default_max_expiry_days');
            $table->boolean('default_require_password')->default(false)->after('default_min_expiry_days');
            $table->unsignedInteger('default_max_view_limit')->default(10)->after('default_require_password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'account_mode',
                'default_max_expiry_days',
                'default_min_expiry_days',
                'default_require_password',
                'default_max_view_limit',
            ]);
        });
    }
};
