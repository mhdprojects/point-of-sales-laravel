<?php

namespace App\Providers;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\PaymentMethod\PaymentMethodRepository;
use App\Repositories\PaymentMethod\PaymentMethodRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Sales\SalesRepository;
use App\Repositories\Sales\SalesRepositoryInterface;
use App\Repositories\Unit\UnitRepository;
use App\Repositories\Unit\UnitRepositoryInterface;
use App\Service\CategoryService;
use App\Service\PaymentMethodService;
use App\Service\ProductService;
use App\Service\SalesService;
use App\Service\UnitService;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void{
        Vite::prefetch(concurrency: 3);

        //Category
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(CategoryService::class, function ($app) {
            return new CategoryService($app->make(CategoryRepositoryInterface::class));
        });

        //Unit
        $this->app->bind(UnitRepositoryInterface::class, UnitRepository::class);
        $this->app->bind(UnitService::class, function ($app) {
            return new UnitService($app->make(UnitRepositoryInterface::class));
        });

        //Product
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductService::class, function ($app) {
            return new ProductService($app->make(ProductRepositoryInterface::class));
        });

        //PaymentMethod
        $this->app->bind(PaymentMethodRepositoryInterface::class, PaymentMethodRepository::class);
        $this->app->bind(PaymentMethodService::class, function ($app) {
            return new PaymentMethodService($app->make(PaymentMethodRepositoryInterface::class));
        });

        //Sales
        $this->app->bind(SalesRepositoryInterface::class, SalesRepository::class);
        $this->app->bind(SalesService::class, function ($app) {
            return new SalesService($app->make(SalesRepositoryInterface::class));
        });
    }
}
