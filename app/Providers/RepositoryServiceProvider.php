<?php

namespace App\Providers;

use App\Repository\BaseRepositoryInterface;
use App\Repository\CheckoutRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\CheckoutRepository;
use App\Repository\Eloquent\ImageRepository;
use App\Repository\Eloquent\OrdersRepository;
use App\Repository\Eloquent\PermissionRepository;
use App\Repository\Eloquent\ProductRepository;
use App\Repository\Eloquent\RegisterRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\ImageRepositoryInterface;
use App\Repository\OrdersRepositoryInterface;
use App\Repository\PermissionRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Repository\RegisterRepositoryInterface;
use App\Repository\RoleRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(RegisterRepositoryInterface::class, RegisterRepository::class);
        $this->app->bind(CheckoutRepositoryInterface::class, CheckoutRepository::class);
        $this->app->bind(OrdersRepositoryInterface::class, OrdersRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepositoryInterface::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ImageRepositoryInterface::class, ImageRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
