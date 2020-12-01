<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register Interface and Repository in here
        // You must place Interface in first place
        // If you dont, the Repository will not get readed.
        $this->app->bind(
            'App\Interfaces\CategoryRepository',
            'App\Repositories\CategoryRepositoryImp'
        );

        $this->app->bind(
            'App\Interfaces\ProductRepository',
            'App\Repositories\ProductRepositoryImp'
        );

        $this->app->bind(
            'App\Interfaces\PurchaseRepository',
            'App\Repositories\PurchaseRepositoryImp'
        );
    }
}
