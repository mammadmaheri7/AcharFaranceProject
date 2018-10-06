<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebDesignOrder extends Model
{
    protected $fillable = ['url'];

    public function orders()
    {
        return $this->morphMany('App\Order','orderable');
    }
}
