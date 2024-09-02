<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->defineRoutes();
    }

    /**
     * Define the application routes.
     *
     * @return void
     */
    protected function defineRoutes()
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }

    /**
     * Configure the rate limits for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        //
    }
}
