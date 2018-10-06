<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MotionGraphicOrder extends Model
{
    protected $fillable = ['time'];

    public function orders()
    {
        return $this->morphMany('App\Order','orderable');
    }
}
