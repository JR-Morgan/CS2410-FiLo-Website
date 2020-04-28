<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Response;
use App\Item;
use App\User;
use App\ItemRequest;

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
        //Admin has all privilages
        Gate::before(function ($user)
        {
            if($user->role)
            {
                return true;
            }
        });

        //Item
        Gate::define('itemShowDetails', function (User $user)
        {
            return $user;
        });
        Gate::define('itemCreate', function (User $user)
        {
            return $user;
        });
        Gate::define('itemEdit', function (User $user, Item $item)
        {
            return $item->found_userid == $user->id;
        });
        Gate::define('itemDelete', function (User $user, Item $item)
        {
            return $item->found_userid == $user->id;
        });
        //Requests
        Gate::define('itemRequestDelete', function (User $user, ItemRequest $itemRequest)
        {
            return $item->userid == $user->id;
        });
        Gate::define('itemRequestShow', function (User $user, ItemRequest $itemRequest)
        {
            //abort(400, "{$itemRequest} == {$user}");
            return $itemRequest->claim_userid == $user->id;
        });
        Gate::define('itemRequestEdit', function (User $user, ItemRequest $itemRequest)
        {
            return $itemRequest->claim_userid == $user->id;
        });
        Gate::define('itemRequestCreate', function (User $user, Item $item)
        {
            return $user;
        });
        Gate::define('itemRequestViewAll', function (User $user)
        {
            return false;
        });
    }
}
