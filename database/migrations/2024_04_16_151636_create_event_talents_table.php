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
        Schema::create('event_talents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained(
                table: 'events', indexName: 'event_talents_event_id_foreign'
            )->onDelete('cascade');
            $table->foreignId('talent_id')->constrained(
                table: 'talents', indexName: 'event_talents_talent_id_foreign'
            )->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_talents');
    }
};
