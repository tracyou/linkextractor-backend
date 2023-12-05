<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('annotation_law', function (Blueprint $table) {
            $table->foreignUuid('law_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('annotation_id')->constrained()->cascadeOnDelete();
            $table->integer('cursor_index');
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['law_id', 'annotation_id', 'cursor_index']);
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
