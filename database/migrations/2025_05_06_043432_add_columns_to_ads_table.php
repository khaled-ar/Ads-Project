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
        Schema::table('ads', function (Blueprint $table) {
            $table->string('company_name')->after('status');
            $table->string('regions')->after('company_name');
            $table->string('duration')->after('regions');
            $table->string('centers')->after('duration');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn([
                'company_name',
                'regions',
                'duration',
                'centers'
            ]);
        });
    }
};
