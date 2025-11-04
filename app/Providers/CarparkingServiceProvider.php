<?php

namespace App\Providers;

use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use App\Core\Carparking\CarparkingPolicy\CarparkingPolicyDetails;

class CarparkingServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\\Core\\Carparking\CarparkingPolicy\\CarparkingPolicy', function () {
            return new CarparkingPolicyDetails();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
