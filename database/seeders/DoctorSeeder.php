<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\College;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = [
            [
                'name' => 'د. أحمد محمد عبدالرحمن',
                'email' => 'ahmed.mohamed@neonerd.com',
                'password' => Hash::make('password'),
                'phone' => '01012345678',
                'specialization' => 'طب الباطنة',
                'bio' => 'أستاذ الطب الباطني بكلية الطب، خبرة أكثر من 15 عامًا في التدريس والممارسة الطبية.',
                'is_active' => true,
            ],
            [
                'name' => 'د. فاطمة علي حسن',
                'email' => 'fatma.ali@neonerd.com',
                'password' => Hash::make('password'),
                'phone' => '01087654321',
                'specialization' => 'هندسة الحاسوب',
                'bio' => 'أستاذ مساعد بكلية الهندسة، متخصصة في الذكاء الاصطناعي وعلوم الحاسوب.',
                'is_active' => true,
            ],
            [
                'name' => 'د. محمد إبراهيم السيد',
                'email' => 'mohamed.ibrahim@neonerd.com',
                'password' => Hash::make('password'),
                'phone' => '01123456789',
                'specialization' => 'الفيزياء النظرية',
                'bio' => 'أستاذ الفيزياء النظرية بكلية العلوم، باحث في مجال فيزياء الجسيمات.',
                'is_active' => true,
            ],
            [
                'name' => 'د. نورا عبدالله أحمد',
                'email' => 'nora.abdullah@neonerd.com',
                'password' => Hash::make('password'),
                'phone' => '01198765432',
                'specialization' => 'القانون التجاري',
                'bio' => 'أستاذ القانون التجاري بكلية الحقوق، خبيرة في قانون الشركات والاستثمار.',
                'is_active' => true,
            ],
            [
                'name' => 'د. خالد محمود عثمان',
                'email' => 'khaled.mahmoud@neonerd.com',
                'password' => Hash::make('password'),
                'phone' => '01056789123',
                'specialization' => 'إدارة الأعمال',
                'bio' => 'أستاذ إدارة الأعمال بكلية التجارة، مستشار في التخطيط الاستراتيجي وريادة الأعمال.',
                'is_active' => true,
            ],
            [
                'name' => 'د. سارة حسن عبدالعزيز',
                'email' => 'sara.hassan@neonerd.com',
                'password' => Hash::make('password'),
                'phone' => '01034567890',
                'specialization' => 'الأدب العربي',
                'bio' => 'أستاذ الأدب العربي بكلية الآداب، متخصصة في الشعر العربي الحديث.',
                'is_active' => true,
            ],
            [
                'name' => 'د. عمر عبدالرحمن طه',
                'email' => 'omar.abdelrahman@neonerd.com',
                'password' => Hash::make('password'),
                'phone' => '01145678901',
                'specialization' => 'طب الأطفال',
                'bio' => 'أستاذ طب الأطفال بكلية الطب، استشاري أطفال بخبرة 20 عامًا.',
                'is_active' => true,
            ],
            [
                'name' => 'د. منى صلاح الدين',
                'email' => 'mona.salah@neonerd.com',
                'password' => Hash::make('password'),
                'phone' => '01067890123',
                'specialization' => 'علم النفس التربوي',
                'bio' => 'أستاذ علم النفس التربوي بكلية التربية، خبيرة في صعوبات التعلم.',
                'is_active' => true,
            ],
            [
                'name' => 'د. يوسف محمد رضا',
                'email' => 'youssef.mohamed@neonerd.com',
                'password' => Hash::make('password'),
                'phone' => '01078901234',
                'specialization' => 'الهندسة المدنية',
                'bio' => 'أستاذ الهندسة المدنية، متخصص في هندسة الإنشاءات والجسور.',
                'is_active' => true,
            ],
            [
                'name' => 'د. ريم أحمد فؤاد',
                'email' => 'reem.ahmed@neonerd.com',
                'password' => Hash::make('password'),
                'phone' => '01089012345',
                'specialization' => 'الصيدلة الإكلينيكية',
                'bio' => 'أستاذ الصيدلة الإكلينيكية بكلية الصيدلة، خبيرة في العلاج الدوائي.',
                'is_active' => true,
            ],
        ];

        // Get some colleges to assign doctors to
        $universities = \App\Models\University::all();

        foreach ($doctors as $index => $doctorData) {
            if ($universities->count() > 0) {
                $doctorData['university_id'] = $universities->random()->id;
            }

            \App\Models\Doctor::create($doctorData);
        }
    }
}
