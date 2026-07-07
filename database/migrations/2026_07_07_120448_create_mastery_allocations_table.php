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
        Schema::create('mastery_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_range_id')->constrained()->cascadeOnDelete();
            $table->string('mastery_node_id');
            $table->string('effect_id');
            $table->timestamps();

            $table->unique(['level_range_id', 'mastery_node_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mastery_allocations');
    }
};
