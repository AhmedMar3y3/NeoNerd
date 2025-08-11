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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('academic_level'); // university, secondary
            $table->string('type')->nullable(); // scientific, literal, both (for secondary)
            
            // For university subjects - linked to college type and grade level
            $table->foreignId('college_type_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('grade_level')->nullable(); // 1, 2, 3, 4, 5, 6 for university grades
            
            // For secondary subjects - linked to secondary type, grade level and section
            $table->foreignId('secondary_type_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('secondary_grade')->nullable(); // first, second, third
            $table->string('secondary_section')->nullable(); // literal, scientific
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['academic_level', 'college_type_id', 'grade_level']);
            $table->index(['academic_level', 'secondary_type_id', 'secondary_grade', 'secondary_section']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
