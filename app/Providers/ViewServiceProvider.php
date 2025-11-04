<?php

namespace App\Providers;

use App\View\OrgNameComposer;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * @return void
     */
    public function boot()
    {
        view()->composer("*","App\Http\ViewComposers\MenuViewComposer");
        view()->composer("*","App\View\OrgNameComposer");
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}