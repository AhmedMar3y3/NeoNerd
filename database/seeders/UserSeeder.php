<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\Gender;
use App\Enums\AcademicLevel;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'أحمد',
                'last_name' => 'محمد',
                'phone' => '01012345678',
                'code' => '1234',
                'is_verified' => true,
                'gender' => Gender::MALE->value,
                'academic_level' => AcademicLevel::UNIVERSITY->value,
                'is_active' => true,
                'is_academic_details_set' => true,
            ],
            [
                'first_name' => 'فاطمة',
                'last_name' => 'علي',
                'phone' => '01087654321',
                'code' => '5678',
                'is_verified' => true,
                'gender' => Gender::FEMALE->value,
                'academic_level' => AcademicLevel::UNIVERSITY->value,
                'is_active' => true,
                'is_academic_details_set' => true,
            ],
            [
                'first_name' => 'محمد',
                'last_name' => 'إبراهيم',
                'phone' => '01123456789',
                'code' => '9012',
                'is_verified' => true,
                'gender' => Gender::MALE->value,
                'academic_level' => AcademicLevel::SECONDARY->value,
                'is_active' => true,
                'is_academic_details_set' => false,
            ],
            [
                'first_name' => 'نورا',
                'last_name' => 'حسن',
                'phone' => '01198765432',
                'code' => '3456',
                'is_verified' => true,
                'gender' => Gender::FEMALE->value,
                'academic_level' => AcademicLevel::UNIVERSITY->value,
                'is_active' => true,
                'is_academic_details_set' => true,
            ],
            [
                'first_name' => 'خالد',
                'last_name' => 'عبدالله',
                'phone' => '01056789123',
                'code' => '7890',
                'is_verified' => false,
                'gender' => Gender::MALE->value,
                'academic_level' => AcademicLevel::UNIVERSITY->value,
                'is_active' => true,
                'is_academic_details_set' => false,
            ],
            [
                'first_name' => 'سارة',
                'last_name' => 'أحمد',
                'phone' => '01034567890',
                'code' => '2345',
                'is_verified' => true,
                'gender' => Gender::FEMALE->value,
                'academic_level' => AcademicLevel::SECONDARY->value,
                'is_active' => true,
                'is_academic_details_set' => true,
            ],
            [
                'first_name' => 'عمر',
                'last_name' => 'محمود',
                'phone' => '01145678901',
                'code' => '6789',
                'is_verified' => true,
                'gender' => Gender::MALE->value,
                'academic_level' => AcademicLevel::UNIVERSITY->value,
                'is_active' => true,
                'is_academic_details_set' => true,
            ],
            [
                'first_name' => 'منى',
                'last_name' => 'صلاح',
                'phone' => '01067890123',
                'code' => '0123',
                'is_verified' => true,
                'gender' => Gender::FEMALE->value,
                'academic_level' => AcademicLevel::UNIVERSITY->value,
                'is_active' => true,
                'is_academic_details_set' => false,
            ],
            [
                'first_name' => 'يوسف',
                'last_name' => 'رضا',
                'phone' => '01078901234',
                'code' => '4567',
                'is_verified' => false,
                'gender' => Gender::MALE->value,
                'academic_level' => AcademicLevel::SECONDARY->value,
                'is_active' => true,
                'is_academic_details_set' => false,
            ],
            [
                'first_name' => 'ريم',
                'last_name' => 'فؤاد',
                'phone' => '01089012345',
                'code' => '8901',
                'is_verified' => true,
                'gender' => Gender::FEMALE->value,
                'academic_level' => AcademicLevel::UNIVERSITY->value,
                'is_active' => true,
                'is_academic_details_set' => true,
            ],
            [
                'first_name' => 'مصطفى',
                'last_name' => 'عبدالعزيز',
                'phone' => '01090123456',
                'code' => '2109',
                'is_verified' => true,
                'gender' => Gender::MALE->value,
                'academic_level' => AcademicLevel::UNIVERSITY->value,
                'is_active' => true,
                'is_academic_details_set' => true,
            ],
            [
                'first_name' => 'ياسمين',
                'last_name' => 'طارق',
                'phone' => '01001234567',
                'code' => '5432',
                'is_verified' => true,
                'gender' => Gender::FEMALE->value,
                'academic_level' => AcademicLevel::SECONDARY->value,
                'is_active' => true,
                'is_academic_details_set' => false,
            ],
            [
                'first_name' => 'حسام',
                'last_name' => 'الدين',
                'phone' => '01112345678',
                'code' => '8765',
                'is_verified' => false,
                'gender' => Gender::MALE->value,
                'academic_level' => AcademicLevel::UNIVERSITY->value,
                'is_active' => true,
                'is_academic_details_set' => false,
            ],
            [
                'first_name' => 'دينا',
                'last_name' => 'مصطفى',
                'phone' => '01223456789',
                'code' => '1098',
                'is_verified' => true,
                'gender' => Gender::FEMALE->value,
                'academic_level' => AcademicLevel::UNIVERSITY->value,
                'is_active' => true,
                'is_academic_details_set' => true,
            ],
            [
                'first_name' => 'كريم',
                'last_name' => 'صابر',
                'phone' => '01134567890',
                'code' => '3210',
                'is_verified' => true,
                'gender' => Gender::MALE->value,
                'academic_level' => AcademicLevel::SECONDARY->value,
                'is_active' => true,
                'is_academic_details_set' => true,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
