<?php

namespace App\Providers;

use App\Interfaces\BrandRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
