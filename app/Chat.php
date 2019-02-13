<?php

namespace App;

use App\Events\BroadcastChat;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $dispatchesEvents = [
        'created' => BroadcastChat::class
    ];
    protected $fillable = ['user_id','friend_id','chat'];
}
