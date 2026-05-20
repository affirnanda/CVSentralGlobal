<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        //
        Gate::before(function ($user, $ability) {
            return true;
        });

        // Auto-seed default Super Admin if users table is empty
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('users') && \App\Models\User::count() === 0) {
                \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'RolePermisionSeeder']);
            }
        } catch (\Exception $e) {
            // Table doesn't exist yet or connection failure, ignore
        }
    }
}
