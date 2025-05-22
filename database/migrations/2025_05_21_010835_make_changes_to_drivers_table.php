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
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn([
                'age',
                'car_name',
                'details_file'
            ]);
            $table->date('birth_date')->after('work_status')->default(now());
            $table->string('car_model')->after('car_color')->default('bmw');
            $table->string('personal_id_image')->unique()->after('gender');
            $table->string('driving_license_image')->unique()->after('personal_id_image');
            $table->string('car_mechanics_image')->unique()->after('driving_license_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            //
        });
    }
};
