<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function getUrlPath()
    {
        return Storage::url($this->photo_path);
    }
}
