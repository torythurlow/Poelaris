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
        Schema::create('level_ranges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained()->cascadeOnDelete();
            $table->string('label');
            $table->unsignedTinyInteger('level_min');
            $table->unsignedTinyInteger('level_max');
            $table->unsignedSmallInteger('sort_order');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['template_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_ranges');
    }
};
