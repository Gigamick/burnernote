<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('note_attachments', function (Blueprint $table) {
            // Drop the existing foreign key with cascade delete
            $table->dropForeign(['note_id']);

            // Make note_id nullable (note will be deleted but attachment stays)
            $table->unsignedBigInteger('note_id')->nullable()->change();

            // Re-add foreign key with SET NULL on delete
            $table->foreign('note_id')
                ->references('id')
                ->on('notes')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('note_attachments', function (Blueprint $table) {
            $table->dropForeign(['note_id']);

            $table->unsignedBigInteger('note_id')->nullable(false)->change();

            $table->foreign('note_id')
                ->references('id')
                ->on('notes')
                ->cascadeOnDelete();
        });
    }
};
