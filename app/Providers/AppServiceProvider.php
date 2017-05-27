<?php

namespace App\Providers;

use App\Helpers\Balance;
use App\Helpers\DataProvider;
use App\Models\DeliveryAddress;
use App\Notifications\MessageToSlackNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use App\Helpers\UsersRoles;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', 'App\Views\Composers\AuthComposer');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->singleton('App\Helpers\UsersRoles', UsersRoles::class);
        $this->app->singleton(DataProvider::class, function ($app) {
            return new DataProvider();
        });
    }
}
