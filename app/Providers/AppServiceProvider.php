<?php

namespace App\Providers;

use App\Models\Major;
use App\Models\Student;
use App\Models\Subject;
use App\Models\EntryYear;
use App\Models\SchoolClass;
use App\Models\SubjectType;
use App\Observers\MajorObserver;
use App\Observers\StudentObserver;
use App\Observers\SubjectObserver;
use App\Observers\EntryYearObserver;
use Illuminate\Pagination\Paginator;
use App\Observers\SubjetTypeObserver;
use Illuminate\Support\Facades\Blade;
use App\Observers\SchoolClassObserver;
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
        SchoolClass::observe(SchoolClassObserver::class);
        SubjectType::observe(SubjetTypeObserver::class);
        EntryYear::observe(EntryYearObserver::class);
        Student::observe(StudentObserver::class);
        Artisan::call('db:seed', ['--class' => 'EntryYearSeeder']);
        Artisan::call('db:seed', ['--class' => 'GraduationYearSeeder']);
        Paginator::useBootstrapFive();

        Blade::if('role', function ($role) {
            return auth()->check() && auth()->user()->role == $role;
        });
    }
}
