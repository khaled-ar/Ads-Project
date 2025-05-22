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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('place_of_residence', ['دمشق', 'القاهرة']);
            $table->string('work_status');
            $table->tinyInteger('age');
            $table->string('number')->unique();
            $table->enum('nationality', ['سوري', 'مصري']);
            $table->enum('gender', ['ذكر', 'انثى']);
            $table->string('details_file')->unique();
            $table->string('car_name');
            $table->string('car_color');
            $table->string('car_number')->unique();
            $table->integer('car_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
