<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\CategoryRepositoryInterface;
use App\Domain\Repositories\CategoryRepository;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\Repositories\ProductRepository;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Repositories\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
