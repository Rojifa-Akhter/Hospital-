<?php
namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class BaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Repositories\BaseRepositoryInterface',
            'App\Repositories\UserRepository'
        );
    }
}
?>