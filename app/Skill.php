<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name_english','name_farsi','body'];

    public function scope()
    {
        return $this->belongsTo(Scope::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        //return $this->hasMany(Photo::class);
        return $this->morphMany('App\Photo', 'photoable');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
