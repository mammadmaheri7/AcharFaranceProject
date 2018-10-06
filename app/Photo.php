<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable=['photo_path'];

    /*
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
    */

    public function photoable()
    {
        return $this->morphTo();
    }
}
