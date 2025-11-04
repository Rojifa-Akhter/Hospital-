<?php

namespace App\Providers;

use App\Core\TV\TVServiceDetails;
use Illuminate\Support\ServiceProvider;
use App\Core\TV\PharmacyTVServiceDetails;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\\Core\\TV\\TVService', function() {
            return new TVServiceDetails();
        });
        $this->app->bind('App\\Core\\TV\\PharmacyTVService', function() {
            return new PharmacyTVServiceDetails();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
