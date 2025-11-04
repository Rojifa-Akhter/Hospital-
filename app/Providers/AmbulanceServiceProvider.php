<?php

namespace App\Providers;

use App\Core\Ambulance\AmbulanceDetails;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class AmbulanceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       $this->app->bind('App\\Core\\Ambulance\\Ambulance',function(Container $app){
            return new AmbulanceDetails;
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
