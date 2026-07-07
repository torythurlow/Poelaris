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
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guest_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tree_version_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->unsignedTinyInteger('class_id');
            $table->string('ascendancy_name')->nullable();
            $table->enum('bandit_choice', ['kill_all', 'oak', 'kraityn', 'alira'])->default('kill_all');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};
