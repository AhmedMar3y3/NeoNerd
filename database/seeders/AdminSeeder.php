<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'أحمد محمد',
                'email' => 'admin@neonerd.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ],
            [
                'name' => 'فاطمة علي',
                'email' => 'fatma@neonerd.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ],
            [
                'name' => 'محمد حسن',
                'email' => 'mohamed@neonerd.com',
                'password' => Hash::make('password'),
                'role' => 'assistant',
                'is_active' => true,
            ],
            [
                'name' => 'نورا إبراهيم',
                'email' => 'nora@neonerd.com',
                'password' => Hash::make('password'),
                'role' => 'assistant',
                'is_active' => true,
            ],
            [
                'name' => 'خالد عبدالله',
                'email' => 'khaled@neonerd.com',
                'password' => Hash::make('password'),
                'role' => 'assistant',
                'is_active' => true,
            ],
            [
                'name' => 'سارة أحمد',
                'email' => 'sara@neonerd.com',
                'password' => Hash::make('password'),
                'role' => 'assistant',
                'is_active' => true,
            ],
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
