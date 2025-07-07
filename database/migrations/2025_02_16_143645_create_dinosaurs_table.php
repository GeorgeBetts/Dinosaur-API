<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dinosaurs', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('name');
            $table->string('taxon')->nullable();
            $table->string('period_start')->nullable();
            $table->string('period_end')->nullable();
            $table->string('size_comparison', 255)->nullable();
            $table->string('wikidata_entry', 255);
            $table->string('wikipedia_entry', 255)->nullable();
            $table->timestamps();
            $table->unique('wikidata_entry');
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dinosaurs');
    }
};
