<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }

    public function registerPolicies()
    {
        Gate::before(function ($user)
        {
            if($user->role)
            {
                return true;
            }
        });

        Gate::define('itemShowDetails', function ($user)
        {
            return $user;
        });
        Gate::define('itemCreate', function ($user)
        {
            return $user;
        });
        Gate::define('itemEdit', function ($user, $item)
        {
            return $item->found_userid == $user->id;
        });
        Gate::define('itemDelete', function ($user, $item)
        {
            return $item->found_userid == $user->id;
        });
    }
}
