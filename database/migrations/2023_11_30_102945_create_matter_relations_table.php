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
            $table->foreignUuid('matter_parent_id')->constrained('matters');
            $table->foreignUuid('matter_child_id')->constrained('matters');
            $table->string('relation');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['matter_parent_id', 'matter_child_id']);
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('matter_relations');
    }
};
