<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\Depreciation\DepreciationDetails;

class DepreciationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(
        //     'App\\Core\\Depreciation\\Depreciation',
        //     'App\\Core\\Depreciation\\DepreciationDetails'
        // );

        $this->app->bind('App\\Core\\Depreciation\\Depreciation',function() {
            return new DepreciationDetails();
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
