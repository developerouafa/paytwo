<?php

namespace App\Providers;

use App\Interfaces\Clients\Invoices\InvoiceRepositoryInterface;
use App\Interfaces\Clients\Profiles\ProfileclientRepositoryInterface;
use App\Interfaces\dashboard_user\Clients\ClientRepositoryInterface;
use App\Interfaces\dashboard_user\Finances\BanktransferRepositoryInterface;
use App\Interfaces\dashboard_user\Finances\PaymentgatewayRepositoryInterface;
use App\Interfaces\dashboard_user\Finances\PaymentRepositoryInterface;
use App\Interfaces\dashboard_user\Finances\ReceiptRepositoryInterface;
use App\Interfaces\dashboard_user\Products\mainRepositoryInterface;
use App\Interfaces\dashboard_user\Products\multipeRepositoryInterface;
use App\Interfaces\dashboard_user\Products\productRepositoryInterface;
use App\Interfaces\dashboard_user\Products\promotionRepositoryInterface;
use App\Interfaces\dashboard_user\Products\stockRepositoryInterface;
use App\Interfaces\dashboard_user\Sections\childrenRepositoryInterface;
use App\Interfaces\dashboard_user\Sections\SectionRepositoryInterface;
use App\Repository\Clients\Invoices\InvoicesRepository;
use App\Repository\Clients\Profiles\ProfileclientRepository;
use App\Repository\dashboard_user\Clients\ClientRepository;
use App\Repository\dashboard_user\Finances\BanktransferRepository;
use App\Repository\dashboard_user\Finances\PaymentRepository;
use App\Repository\dashboard_user\Finances\ReceiptRepository;
use App\Repository\dashboard_user\Products\mainimageRepository;
use App\Repository\dashboard_user\Products\multipimageRepository;
use App\Repository\dashboard_user\Products\productRepository;
use App\Repository\dashboard_user\Products\promotionRepository;
use App\Repository\dashboard_user\Products\stockRepository;
use App\Repository\dashboard_user\Sections\childrenRepository;
use App\Repository\dashboard_user\Sections\SectionRepository;
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
        $this->app->bind(ProfileclientRepositoryInterface::class, ProfileclientRepository::class);
        $this->app->bind(ReceiptRepositoryInterface::class, ReceiptRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoicesRepository::class);
        $this->app->bind(BanktransferRepositoryInterface::class, BanktransferRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
