<?php

namespace App\Providers;

use App\Order;
use App\Permission;

use App\Policies\OrderPolicy;
use App\User;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Order::class => OrderPolicy::class,
        'App\Model' => 'App\Policies\ModelPolicy',

    ];

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


    protected function getPermission()
    {
        return Permission::with('roles')->get();
    }

}
