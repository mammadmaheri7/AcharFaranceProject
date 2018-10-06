<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GraphicOrder extends Model
{
    public function orders()
    {
        return $this->morphMany('App\Order','orderable');
    }
}
