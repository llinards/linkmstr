<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('geo_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained()->onDelete('cascade');
            $table->string('country_codes')->nullable(); // Comma-separated country codes (US,CA,GB)
            $table->string('continent_codes')->nullable(); // Comma-separated continent codes (NA,EU,AS)
            $table->string('target_url');
            $table->integer('priority')->default(0); // Higher priority rules are checked first
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['link_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('geo_rules');
    }
};
