<?php

namespace App\Policies;

use App\Order;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function show(User $user,Order $order)
    {
        if($user->id == $order->user_id)
        {
            return true;
        }
        else
        {
            $roles = $user->roles;

            if(!empty($roles))
            {
                foreach ($roles as $role)
                {
                    if($role->name == 'manager')
                    {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function addPhotoPage(User $user,Order $order)
    {
        if($user->id == $order->user_id)
        {
            return true;
        }
        return false;
    }

    public function edit(User $user,Order $order)
    {
        //TODO : check order status for edit
        if($user->id == $order->user_id )
        {
            return true;
        }
        return false;
    }
}
