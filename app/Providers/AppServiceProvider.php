<?php

namespace App\Providers;

use App\Models\Rating;
use App\Models\Lesson;
use App\Observers\RatingObserver;
use App\Observers\LessonObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Rating::observe(RatingObserver::class);
        Lesson::observe(LessonObserver::class);
    }
}
