<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /** Run the migrations. */
    public function up(): void
    {
        Schema::create('matter_relation_schemas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('matter_id')->constrained();
            $table->foreignUuid('relation_schema_id')->constrained();
            $table->json('schema_layout');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('matter_relations', function (Blueprint $table) {
            $table->foreignUuid('matter_relation_schema_id')->after('id')->constrained();
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('matter_relation_schemas');
    }
};
