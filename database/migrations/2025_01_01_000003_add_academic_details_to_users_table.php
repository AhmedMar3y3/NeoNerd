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
        Schema::table('colleges', function (Blueprint $table) {
            $table->foreignId('college_type_id')->nullable()->constrained()->onDelete('set null');
        });

        Schema::table('users', function (Blueprint $table) {
            // University flow fields
            $table->foreignId('university_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('college_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('grade_id')->nullable()->constrained()->onDelete('set null');

            // Secondary flow fields
            $table->foreignId('secondary_type_id')->nullable()->constrained()->onDelete('set null');
            $table->string('secondary_grade')->nullable(); // first, second, third
            $table->string('secondary_section')->nullable(); // literal, scientific
            $table->string('scientific_branch')->nullable(); // science, math
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('colleges', function (Blueprint $table) {
            $table->dropForeign(['college_type_id']);
            $table->dropColumn('college_type_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['university_id']);
            $table->dropForeign(['college_id']);
            $table->dropForeign(['grade_id']);
            $table->dropForeign(['secondary_type_id']);

            $table->dropColumn([
                'university_id',
                'college_id',
                'grade_id',
                'secondary_type_id',
                'secondary_grade',
                'secondary_section',
                'scientific_branch'
            ]);
        });
    }
};
