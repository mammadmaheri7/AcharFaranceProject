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

    protected $user;
    protected $order;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user,Order $order)
    {
        $this -> order = $order;
        $this -> user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(Auth::user())
            -> send(new OrderShipped($user,$order));
    }
}
