<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matter_relations', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->uuid('matter_a_id');
            $table->uuid('matter_b_id');
            $table->enum('relation', ['requires 1', 'requires 0 or 1', 'requires 1 or more', 'requires 0 or more']);
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('matter_a_id')->on('matters')->references('id');
            $table->foreign('matter_b_id')->on('matters')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matter_relations');
    }
};
