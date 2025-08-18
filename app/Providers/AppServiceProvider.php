<?php

namespace App\Providers;

use Laravel\Sanctum\Sanctum;
use App\Repositories\UserRepository;
use App\Repositories\OrderRepository;
use App\Repositories\StoreRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\StoreRepositoryInterface;
use App\Repositories\SessionStateRepository;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\SessionStateRepositoryInterface;
use Illuminate\Support\Facades\Response;
use App\Interfaces\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;

    class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(SessionStateRepositoryInterface::class, SessionStateRepository::class);
        $this->app->bind(StoreRepositoryInterface::class, StoreRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
    }
}
