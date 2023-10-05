<?php

namespace App\Providers;

use App\Interfaces\Sections\childrenRepositoryInterface;
use App\Interfaces\Sections\SectionRepositoryInterface;
use App\Interfaces\Products\productRepositoryInterface;
use App\Repository\Sections\childrenRepository;
use App\Repository\Sections\SectionRepository;
use App\Repository\Products\productRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Section
        $this->app->bind(SectionRepositoryInterface::class, SectionRepository::class);
        $this->app->bind(childrenRepositoryInterface::class, childrenRepository::class);
        $this->app->bind(productRepositoryInterface::class, productRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
