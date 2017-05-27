<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        'App\Models\Catalog' => 'App\Policies\CatalogPolicy',
        'App\Models\Service' => 'App\Policies\ServicePolicy',
        'App\Models\Deal' => 'App\Policies\DealPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
