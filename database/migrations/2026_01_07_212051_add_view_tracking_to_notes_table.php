<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->unsignedTinyInteger('max_views')->default(1)->after('client_encrypted');
            $table->unsignedTinyInteger('view_count')->default(0)->after('max_views');
        });
    }

    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn(['max_views', 'view_count']);
        });
    }
};
