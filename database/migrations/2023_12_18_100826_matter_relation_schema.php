<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matter_relation_schemas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::table('annotations', function (Blueprint $table) {
            $table->foreignUuid('matter_relation_schema_id')->constrained('matter_relation_schemas')->cascadeOnDelete();
        });

        Schema::table('matter_relations', function (Blueprint $table) {
            $table->foreignUuid('matter_relation_schema_id')->constrained('matter_relation_schemas')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matter_relation_schema');
    }
};
