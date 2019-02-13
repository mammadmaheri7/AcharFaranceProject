<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function accounts()
    {
        return $this->hasMany('App\SocialAccount');
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($roles)
    {
        $temp = $roles->intersect($this->roles()->get());
        return !! $temp -> count();
    }

    public function giveRoleTo($role)
    {
        $this->roles()->save($role);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function friendsOfMine()
    {
        return $this->belongsToMany('App\User','friends','user_id','friend_id');
    }

    public function friendOf()
    {
        return $this->belongsToMany('App\User','friends','friend_id','user_id');
    }

    public function friends()
    {
        return $this->friendsOfMine->merge($this->friendOf);
    }
}
