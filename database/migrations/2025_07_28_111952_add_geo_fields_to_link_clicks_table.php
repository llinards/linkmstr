<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('link_clicks', function (Blueprint $table) {
            $table->string('country')->nullable()->after('referer');
            $table->string('country_code', 2)->nullable()->after('country');
            $table->string('city')->nullable()->after('country_code');
            $table->string('continent')->nullable()->after('city');
            $table->string('continent_code', 2)->nullable()->after('continent');

            $table->index(['country_code', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('link_clicks', function (Blueprint $table) {
            $table->dropColumn(['country', 'country_code', 'city', 'continent', 'continent_code']);
        });
    }
};
