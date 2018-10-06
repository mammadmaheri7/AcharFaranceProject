<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scope extends Model
{
    protected $fillable = ['name_english', 'name_farsi', 'body'];

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }
}
