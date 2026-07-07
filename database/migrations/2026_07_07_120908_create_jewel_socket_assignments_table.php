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
        Schema::create('jewel_socket_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_range_id')->constrained()->cascadeOnDelete();
            $table->string('socket_node_id');
            $table->string('jewel_name')->nullable();
            $table->string('notes')->nullable();
            $table->timestamps();

            $table->unique(['level_range_id', 'socket_node_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jewel_socket_assignments');
    }
};
