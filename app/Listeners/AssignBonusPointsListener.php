<?php

namespace App\Listeners;

use App\Events\AssignBonusPointsEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignBonusPointsListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(AssignBonusPointsEvent $event)
    {
        $user = $event->user;
        $order = $event->order;

        $pointsPercent = 3;
        
        if ($user->points_percent > 0)
        {
            $pointsPercent = $user->points_percent;
        } 
            
        $pointsToAdd = ($order->total * $pointsPercent) / 100;

        $user->points += $pointsToAdd;

        $user->save();
    }
}
