<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Client;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        }
        // Cashier::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Cashier::useCustomerModel(User::class);
        // Cashier::useCustomerModel(Client::class);
        // Cashier::calculateTaxes();
    }
}
