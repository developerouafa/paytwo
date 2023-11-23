<?php

namespace App\Providers;

use App\Interfaces\clients\invoices\InvoiceRepositoryInterface;
use App\Interfaces\clients\profiles\ProfileclientRepositoryInterface;
use App\Interfaces\dashboard_user\clients\ClientRepositoryInterface;
use App\Interfaces\dashboard_user\Finances\BanktransferRepositoryInterface;
use App\Interfaces\dashboard_user\Finances\PaymentgatewayRepositoryInterface;
use App\Interfaces\dashboard_user\Finances\PaymentRepositoryInterface;
use App\Interfaces\dashboard_user\Finances\ReceiptRepositoryInterface;
use App\Interfaces\dashboard_user\invoices\GroupProductRepositoryInterface;
use App\Interfaces\dashboard_user\invoices\InvoicesRepositoryInterface;
use App\Interfaces\dashboard_user\products\mainRepositoryInterface;
use App\Interfaces\dashboard_user\products\multipeRepositoryInterface;
use App\Interfaces\dashboard_user\products\productRepositoryInterface;
use App\Interfaces\dashboard_user\products\promotionRepositoryInterface;
use App\Interfaces\dashboard_user\products\stockRepositoryInterface;
use App\Interfaces\dashboard_user\sections\childrenRepositoryInterface;
use App\Interfaces\dashboard_user\sections\SectionRepositoryInterface;
use App\Repository\clients\invoices\InvoicesRepository;
use App\Repository\clients\Profiles\ProfileclientRepository;
use App\Repository\dashboard_user\clients\ClientRepository;
use App\Repository\dashboard_user\Finances\BanktransferRepository;
use App\Repository\dashboard_user\Finances\PaymentGatewayRepository;
use App\Repository\dashboard_user\Finances\PaymentRepository;
use App\Repository\dashboard_user\Finances\ReceiptRepository;
use App\Repository\dashboard_user\invoices\GroupProductRepository;
use App\Repository\dashboard_user\invoices\InvoiceRepository;
use App\Repository\dashboard_user\products\mainimageRepository;
use App\Repository\dashboard_user\products\multipimageRepository;
use App\Repository\dashboard_user\products\productRepository;
use App\Repository\dashboard_user\products\promotionRepository;
use App\Repository\dashboard_user\products\stockRepository;
use App\Repository\dashboard_user\sections\childrenRepository;
use App\Repository\dashboard_user\sections\SectionRepository;
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
        $this->app->bind(PaymentgatewayRepositoryInterface::class, PaymentGatewayRepository::class);
        $this->app->bind(InvoicesRepositoryInterface::class, InvoiceRepository::class);
        $this->app->bind(GroupProductRepositoryInterface::class, GroupProductRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
