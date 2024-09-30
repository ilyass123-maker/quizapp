<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Gate for teachers
        Gate::define('access-teacher-section', function ($user) {
            return $user->type === 'teacher';
        });
        

        // Gate for students
        Gate::define('access-student-section', function ($user) {
            return $user->type === 'student';
        });
    }
    
}
