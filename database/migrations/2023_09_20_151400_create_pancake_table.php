<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pancakes', function (Blueprint $table) {
            $table->id();
            $table->integer('diameter');
            $table->foreignId('pancake_stack_id')->nullable()->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
