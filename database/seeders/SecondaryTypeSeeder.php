<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SecondaryType;

class SecondaryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $secondaryTypes = [
            [
                'name' => 'arabic',
                'description' => 'المدارس الثانوية العربية',
                'is_active' => true,
            ],
            [
                'name' => 'language',
                'description' => 'المدارس الثانوية اللغات',
                'is_active' => true,
            ],
        ];

        foreach ($secondaryTypes as $secondaryType) {
            SecondaryType::create($secondaryType);
        }
    }
}
