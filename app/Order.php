<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['skill_id','body','recommended_price','recommended_deadline'];

    public function orderable()
    {
        return $this->morphTo();
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
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

    public function order_status()
    {
        return $this -> belongsTo('App\OrderStatus');
    }


}
