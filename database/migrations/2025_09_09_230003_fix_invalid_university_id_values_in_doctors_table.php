<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Set university_id to NULL for doctors where the university_id doesn't exist in universities table
        DB::statement('
            UPDATE doctors 
            SET university_id = NULL 
            WHERE university_id IS NOT NULL 
            AND university_id NOT IN (SELECT id FROM universities)
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be reversed as we don't know what the original values were
        // If you need to reverse this, you'll need to manually restore the university_id values
    }
};
