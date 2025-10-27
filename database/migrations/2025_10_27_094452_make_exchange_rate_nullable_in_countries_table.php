<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->decimal('exchange_rate', 15, 6)->nullable()->change();
            $table->decimal('estimated_gdp', 20, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->decimal('exchange_rate', 15, 6)->nullable(false)->change();
            $table->decimal('estimated_gdp', 20, 2)->nullable(false)->change();
        });
    }
};