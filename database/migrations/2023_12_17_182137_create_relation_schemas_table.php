<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /** Run the migrations. */
    public function up(): void
    {
        Schema::create('relation_schemas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('is_published')->default(false);
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('annotations', function (Blueprint $table) {
            $table->foreignUuid('relation_schema_id')->constrained();
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('relation_schemas');
    }
};
