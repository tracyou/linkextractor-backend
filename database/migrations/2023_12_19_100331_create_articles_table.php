<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('text');
            $table->json('json_text')->nullable();
            $table->foreignUuid('law_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('annotations', function (Blueprint $table) {

            $table->foreignUuid('article_id')->constrained()->cascadeOnDelete();

        });
        Schema::table('laws', function (Blueprint $table) {

            $table->foreignUuid('article_id')->nullable()->constrained()->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public
    function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
