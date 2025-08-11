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
            AdminSeeder::class,
            DoctorSeeder::class,
            UserSeeder::class,
        ]);
    }
}
