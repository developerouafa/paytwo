<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        // Inertia::share([
        //     'locale' => function () {
        //         return app()->getLocale();
        //     },
        //     'language' => function () {
        //         return translations(
        //             resource_path('lang/'. app()->getLocale() .'.json')
        //         );
        //     },
        // ]);
    }
}
