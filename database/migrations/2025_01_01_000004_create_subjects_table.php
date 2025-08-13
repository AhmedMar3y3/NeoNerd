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
            $table->string('term');
            $table->string('image')->nullable();
            $table->string('academic_level', 100);
            $table->string('type', 100)->nullable();

            $table->foreignId('college_type_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('grade_level')->nullable();

            $table->string('secondary_type', 100)->nullable();
            $table->string('secondary_grade', 100)->nullable();
            $table->string('secondary_section', 100)->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['academic_level', 'college_type_id', 'grade_level']);
            $table->index(
                ['academic_level', 'secondary_type', 'secondary_grade', 'secondary_section'],
                'subjects_acadlvl_sectype_grade_section_idx'
            );
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
