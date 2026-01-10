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
            $table->dropUnique(['burn_me_uuid']);
            $table->renameColumn('burn_me_uuid', 'burn_me_slug');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('burn_me_slug', 50)->nullable()->change();
            $table->unique('burn_me_slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['burn_me_slug']);
            $table->renameColumn('burn_me_slug', 'burn_me_uuid');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->uuid('burn_me_uuid')->nullable()->change();
            $table->unique('burn_me_uuid');
        });
    }
};
