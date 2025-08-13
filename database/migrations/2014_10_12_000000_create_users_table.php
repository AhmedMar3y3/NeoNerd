<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Gender;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->unique();
            $table->string('code')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('gender')->default(Gender::MALE->value);
            $table->string('academic_level')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('fcm_token')->nullable();
            $table->boolean('is_academic_details_set')->default(false);

            // University flow fields
            $table->foreignId('university_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('college_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('grade_id')->nullable()->constrained()->onDelete('cascade');

            // Secondary flow fields
            $table->string('secondary_type')->nullable(); // arabic, language
            $table->string('secondary_grade')->nullable(); // first, second, third
            $table->string('secondary_section')->nullable(); // literal, scientific
            $table->string('scientific_branch')->nullable(); // science, math
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
