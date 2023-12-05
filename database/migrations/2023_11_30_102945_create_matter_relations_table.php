<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /** Run the migrations. */
    public function up(): void
    {
        Schema::create('matter_relations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('related_matter_id')->constrained('matters');
            $table->string('relation');
            $table->string('description')->nullable();
            $table->string('relation');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('matter_relations');
    }
};
