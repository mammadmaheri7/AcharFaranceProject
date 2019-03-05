<?php

namespace App\Listeners;

use App\Friend;
use App\Role;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Log;

class LogVerifiedUser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        $userFriends = $user->friends();

        //adding managers to friend
        $manager = Role::where('name','manager') -> with('users') ->firstOrFail();
        $managers = $manager -> users;
        foreach ($managers as $mn)
        {
            if(!$userFriends->contains($mn))
            {
                $friend = new Friend([
                    'user_id' => $user->id,
                    'friend_id' => $mn->id
                ]);

                $friend->save();
            }
        }

        //add verifiend_user to roles
        $role = Role::where('name','verified_user') -> firstOrFail();
        $user -> roles() -> save($role);
    }
}
