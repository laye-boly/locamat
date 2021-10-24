<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\ImageInsertionService;

class ImageInsertionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ImageInsertionService::class, function ($app) {
            return new ImageInsertionService();
        });
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
