<?php

namespace App\Providers;

use App\Chat;
use App\Order;
use App\Permission;

use App\Policies\ChatPolicy;
use App\Policies\OrderPolicy;
use App\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();

        foreach ($this->getPermission() as $permission)
        {
            $gate->define($permission->name , function (User $user)use($permission)
            {
                return $user->hasRole($permission->roles);
            });
        }
    }

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Chat::class => ChatPolicy::class,
        Order::class => OrderPolicy::class,

        'App\Model' => 'App\Policies\ModelPolicy',

    ];


    protected function getPermission()
    {
        return Permission::with('roles')->get();
    }

}
