<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UniversitySeeder::class,
            CollegeSeeder::class,
            GradeSeeder::class,
            SecondaryTypeSeeder::class,
            SubjectSeeder::class,
            AdminSeeder::class,
            DoctorSeeder::class,
            UserSeeder::class,
        ]);
    }
}
