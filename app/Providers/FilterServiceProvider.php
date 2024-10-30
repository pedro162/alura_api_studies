<?php

namespace App\Providers;

use App\Filters\FilterManager;
use App\Filters\IdFilter;
use App\Filters\NameFilter;
use Illuminate\Support\ServiceProvider;

class FilterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(FilterManager::class, function ($app) {
            return new FilterManager(
                [
                    'name' => $app->make(NameFilter::class),
                    'id' => $app->make(IdFilter::class),
                ]
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
