<?php

namespace App\Listeners;

use App\Events\SendStatus;
use App\Mail\StatusEmail;
use Illuminate\Support\Facades\Mail;
use Lang;

class SendStatusNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendStatus  $event
     * @return void
     */
    public function handle(SendStatus $event)
    {
        $order = $event->order;

        Mail::to($order->email)->send(new StatusEmail($order));
    }
}
