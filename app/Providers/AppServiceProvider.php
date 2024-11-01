<?php

namespace App\Providers;

use App\Models\Major;
use App\Models\Student;
use App\Models\Subject;
use App\Models\EntryYear;
use App\Observers\MajorObserver;
use App\Observers\StudentObserver;
use App\Observers\SubjectObserver;
use App\Observers\EntryYearObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Major::observe(MajorObserver::class);
        Subject::observe(SubjectObserver::class);
        EntryYear::observe(EntryYearObserver::class);
        Artisan::call('db:seed', ['--class' => 'EntryYearSeeder']);
        Artisan::call('db:seed', ['--class' => 'GraduationYearSeeder']);
        Student::observe(StudentObserver::class);
        Paginator::useBootstrapFive();

        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->role == $role;
        });
    }
}
