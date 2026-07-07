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
        Schema::create('node_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_range_id')->constrained()->cascadeOnDelete();
            $table->string('node_id');
            $table->enum('node_type', ['small', 'notable', 'keystone', 'ascendancy']);
            $table->timestamps();

            $table->unique(['level_range_id', 'node_id']);
            $table->index('node_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('node_allocations');
    }
};
