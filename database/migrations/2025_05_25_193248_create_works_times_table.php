<?php

use App\Models\WorksDays;
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
        Schema::create('works_times', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(WorksDays::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('start');
            $table->string('end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('works_times');
    }
};
