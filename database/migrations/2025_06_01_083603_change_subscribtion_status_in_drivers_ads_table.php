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
        Schema::table('drivers_ads', function (Blueprint $table) {
            $table->enum('status', ['done', 'in_progress', 'approval_wating', 'appointement_booking', 'rejected'])->default('approval_wating')->change();
            $table->string('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers_ads', function (Blueprint $table) {
            //
        });
    }
};
