<?php

declare(strict_types=1);

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
        Schema::create('law_annotation', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('law_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('annotations_id')->constrained()->cascadeOnDelete();
            $table->integer('cursor_index');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laws_annotations');
    }
};
