<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add indexes to link_clicks table for analytics performance
        Schema::table('link_clicks', function (Blueprint $table) {
            // Index for time-based analytics
            $table->index('created_at');

            // Index for referrer analysis
            $table->index('referer');

            // Compound index for continent analytics
            $table->index(['continent_code', 'created_at']);

            // Index for link_id + created_at for fast time-series queries per link
            $table->index(['link_id', 'created_at']);
        });

        // Add indexes to geo_rules table
        Schema::table('geo_rules', function (Blueprint $table) {
            // Index for finding rules by country code quickly
            $table->index('country_codes');

            // Index for finding rules by continent code quickly
            $table->index('continent_codes');

            // Compound index for active rules with priority
            $table->index(['link_id', 'is_active', 'priority']);
        });

        // Add index to links table for expiration checks
        Schema::table('links', function (Blueprint $table) {
            // Index for expiration date queries
            $table->index('expires_at');

            // Compound index for active and non-expired links
            $table->index(['is_active', 'expires_at']);

            // Index for user's links
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        // Remove added indexes from link_clicks table
        Schema::table('link_clicks', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['referer']);
            $table->dropIndex(['continent_code', 'created_at']);
            $table->dropIndex(['link_id', 'created_at']);
        });

        // Remove added indexes from geo_rules table
        Schema::table('geo_rules', function (Blueprint $table) {
            $table->dropIndex(['country_codes']);
            $table->dropIndex(['continent_codes']);
            $table->dropIndex(['link_id', 'is_active', 'priority']);
        });

        // Remove added indexes from links table
        Schema::table('links', function (Blueprint $table) {
            $table->dropIndex(['expires_at']);
            $table->dropIndex(['is_active', 'expires_at']);
            $table->dropIndex(['user_id', 'created_at']);
        });
    }
};
