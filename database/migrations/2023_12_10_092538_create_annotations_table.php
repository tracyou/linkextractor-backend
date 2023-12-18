<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /** Run the migrations. */
    public function up(): void
    {
        Schema::create('annotations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text("text");
            $table->text('comment')->nullable();
            $table->integer('cursor_index');
            $table->foreignUuid('law_id')->nullable();
            $table->foreignUuid('matter_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('article_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('annotations');
    }
};
