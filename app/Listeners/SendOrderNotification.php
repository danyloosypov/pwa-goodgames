<?php

namespace App\Listeners;

use App\Events\SendOrder;
use App\Mail\OrderEmail;
use Illuminate\Support\Facades\Mail;
use Lang;

class SendOrderNotification
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
     * @param  \App\Events\SendOrder  $event
     * @return void
     */
    public function handle(SendOrder $event)
    {
        $order = $event->item;

        Mail::to(env('ADMIN_EMAIL'))->send(new OrderEmail($order));
    }
}
