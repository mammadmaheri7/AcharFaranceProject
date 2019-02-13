<?php

namespace App\Mail;

use App\Order;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $order;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,Order $order)
    {
        $this->user = $user;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this -> from('mohamadmaheri7777@gmail.com')
                     -> view('email.orderShipped');
    }
}


//TODO : orderShipEmail and verificationEmail should be queued
