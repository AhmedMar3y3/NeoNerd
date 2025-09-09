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
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign('doctors_college_id_foreign');
            
            $table->foreign('university_id')->references('id')->on('universities')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign(['university_id']);
            
            // Restore the old foreign key constraint to colleges table
            $table->foreign('university_id')->references('id')->on('colleges')->onDelete('set null');
        });
    }
};
