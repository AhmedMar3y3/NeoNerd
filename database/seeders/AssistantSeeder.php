<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AssistantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assistant = [
            'name'     => 'أحمد مرعي',
            'email'    => 'ahmed@neonerd.com',
            'password' => Hash::make('password'),
            'doctor_id'    => '1',
        ];

        \App\Models\Assistant::insert($assistant);
    }
}
