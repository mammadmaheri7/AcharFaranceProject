<?php

namespace App\Jobs;

use App\Mail\OrderShipped;
use App\Order;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendCreateOrderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $order;
    public $user;
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param Order $order
     */
    public function __construct(Order $order,User $user)
    {
        $this -> order = $order;
        $this -> user = $user;
    }

    /**
     * Execute the job.
     *
     * @param User $user
     * @param Order $order
     */
    public function handle()
    {

        //dd($this->user->email);
        Mail::to($this->user->email)
            -> send(new OrderShipped($this->user,$this->order));

    }
}
