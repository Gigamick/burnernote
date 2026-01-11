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
        Schema::create('note_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('note_id')->constrained()->cascadeOnDelete();
            $table->string('encrypted_filename');
            $table->string('storage_path');
            $table->string('mime_type')->nullable();
            $table->unsignedInteger('size');
            $table->timestamps();

            $table->index('note_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_attachments');
    }
};
