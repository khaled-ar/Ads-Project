<?php

use App\Http\Middleware\Driver;
use App\Models\Ad;
use App\Models\Center;
use App\Models\User;
use App\Models\WorksDays;
use App\Models\WorksTimes;
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
        Schema::create('appointements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('driver_id')->constrained('drivers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('ad_id')->constrained('ads')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('center_id')->constrained('centers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('works_days_id')->constrained('works_days')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('time');
            $table->enum('status', ['to check', 'to do', 'canceled', 'done'])->default('to check');
            $table->string('notes')->nullable();
            $table->string('lables');
            $table->unique([
                'driver_id',
                'ad_id'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointements');
    }
};
