<?php

namespace App\Providers;

use App\Interfaces\Clients\ClientRepositoryInterface;
use App\Interfaces\Clients\Profiles\ProfileclientRepositoryInterface as ProfilesProfileclientRepositoryInterface;
use App\Interfaces\dashboard_user\Finances\ReceiptRepositoryInterface;
use App\Interfaces\Products\mainRepositoryInterface;
use App\Interfaces\Products\multipeRepositoryInterface;
use App\Interfaces\Sections\childrenRepositoryInterface;
use App\Interfaces\Sections\SectionRepositoryInterface;
use App\Interfaces\Products\productRepositoryInterface;
use App\Interfaces\Products\promotionRepositoryInterface;
use App\Interfaces\Products\stockRepositoryInterface;
use App\Repository\Clients\ClientRepository;
use App\Repository\Clients\Profiles\ProfileclientRepository;
use App\Repository\dashboard_user\Finances\ReceiptRepository;
use App\Repository\Products\mainimageRepository;
use App\Repository\Products\multipimageRepository;
use App\Repository\Sections\childrenRepository;
use App\Repository\Sections\SectionRepository;
use App\Repository\Products\productRepository;
use App\Repository\Products\promotionRepository;
use App\Repository\Products\stockRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SectionRepositoryInterface::class, SectionRepository::class);
        $this->app->bind(childrenRepositoryInterface::class, childrenRepository::class);
        $this->app->bind(productRepositoryInterface::class, productRepository::class);
        $this->app->bind(promotionRepositoryInterface::class, promotionRepository::class);
        $this->app->bind(stockRepositoryInterface::class, stockRepository::class);
        $this->app->bind(mainRepositoryInterface::class, mainimageRepository::class);
        $this->app->bind(multipeRepositoryInterface::class, multipimageRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(ProfilesProfileclientRepositoryInterface::class, ProfileclientRepository::class);
        $this->app->bind(ReceiptRepositoryInterface::class, ReceiptRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
