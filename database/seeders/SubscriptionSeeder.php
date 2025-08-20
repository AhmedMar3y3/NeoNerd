<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Course;
use App\Models\Book;
use App\Enums\SubscriptionType;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing users, courses, and books
        $users = User::all();
        $courses = Course::where('is_active', true)->get();
        $books = Book::where('is_active', true)->get();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        if ($courses->isEmpty() && $books->isEmpty()) {
            $this->command->warn('No active courses or books found. Please run CourseSeeder and BookSeeder first.');
            return;
        }

        // Create course subscriptions
        foreach ($courses as $course) {
            // Create 2-5 subscriptions per course
            $subscriptionCount = rand(2, 5);
            $selectedUsers = $users->random($subscriptionCount);
            
            foreach ($selectedUsers as $user) {
                // Check if user already has an active course subscription
                $existingSubscription = Subscription::where('user_id', $user->id)
                    ->where('subscription_type', SubscriptionType::COURSE->value)
                    ->where('is_active', true)
                    ->first();

                if (!$existingSubscription) {
                    Subscription::create([
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                        'book_id' => null,
                        'subscription_type' => SubscriptionType::COURSE->value,
                        'is_active' => rand(0, 10) > 1, // 90% chance of being active
                        'created_at' => now()->subDays(rand(1, 90)),
                        'updated_at' => now()->subDays(rand(0, 30)),
                    ]);
                }
            }
        }

        // Create book subscriptions
        foreach ($books as $book) {
            // Create 1-3 subscriptions per book
            $subscriptionCount = rand(1, 3);
            $selectedUsers = $users->random($subscriptionCount);
            
            foreach ($selectedUsers as $user) {
                // Check if user already has an active book subscription
                $existingSubscription = Subscription::where('user_id', $user->id)
                    ->where('subscription_type', SubscriptionType::BOOK->value)
                    ->where('is_active', true)
                    ->first();

                if (!$existingSubscription) {
                    Subscription::create([
                        'user_id' => $user->id,
                        'course_id' => null,
                        'book_id' => $book->id,
                        'subscription_type' => SubscriptionType::BOOK->value,
                        'is_active' => rand(0, 10) > 2, // 80% chance of being active
                        'created_at' => now()->subDays(rand(1, 60)),
                        'updated_at' => now()->subDays(rand(0, 20)),
                    ]);
                }
            }
        }

        // Create some mixed subscriptions (users with both course and book subscriptions)
        $mixedUsers = $users->random(min(5, $users->count()));
        
        foreach ($mixedUsers as $user) {
            // Give them a course subscription
            if ($courses->isNotEmpty()) {
                $course = $courses->random();
                $existingCourseSubscription = Subscription::where('user_id', $user->id)
                    ->where('course_id', $course->id)
                    ->first();

                if (!$existingCourseSubscription) {
                    Subscription::create([
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                        'book_id' => null,
                        'subscription_type' => SubscriptionType::COURSE->value,
                        'is_active' => true,
                        'created_at' => now()->subDays(rand(10, 45)),
                        'updated_at' => now()->subDays(rand(0, 10)),
                    ]);
                }
            }

            // Give them a book subscription (inactive)
            if ($books->isNotEmpty()) {
                $book = $books->random();
                $existingBookSubscription = Subscription::where('user_id', $user->id)
                    ->where('book_id', $book->id)
                    ->first();

                if (!$existingBookSubscription) {
                    Subscription::create([
                        'user_id' => $user->id,
                        'course_id' => null,
                        'book_id' => $book->id,
                        'subscription_type' => SubscriptionType::BOOK->value,
                        'is_active' => false, // Inactive book subscription
                        'created_at' => now()->subDays(rand(20, 60)),
                        'updated_at' => now()->subDays(rand(5, 15)),
                    ]);
                }
            }
        }

        // Create some recent subscriptions (last 7 days)
        $recentUsers = $users->random(min(3, $users->count()));
        foreach ($recentUsers as $user) {
            if ($courses->isNotEmpty()) {
                $course = $courses->random();
                $existingSubscription = Subscription::where('user_id', $user->id)
                    ->where('course_id', $course->id)
                    ->first();

                if (!$existingSubscription) {
                    Subscription::create([
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                        'book_id' => null,
                        'subscription_type' => SubscriptionType::COURSE->value,
                        'is_active' => true,
                        'created_at' => now()->subDays(rand(1, 7)),
                        'updated_at' => now()->subDays(rand(0, 2)),
                    ]);
                }
            }
        }

        $totalSubscriptions = Subscription::count();
        $activeSubscriptions = Subscription::where('is_active', true)->count();
        $courseSubscriptions = Subscription::where('subscription_type', SubscriptionType::COURSE->value)->count();
        $bookSubscriptions = Subscription::where('subscription_type', SubscriptionType::BOOK->value)->count();

        $this->command->info("Subscriptions seeded successfully!");
        $this->command->info("Total subscriptions: {$totalSubscriptions}");
        $this->command->info("Active subscriptions: {$activeSubscriptions}");
        $this->command->info("Course subscriptions: {$courseSubscriptions}");
        $this->command->info("Book subscriptions: {$bookSubscriptions}");
    }
}
