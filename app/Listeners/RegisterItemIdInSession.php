<?php

namespace App\Listeners;

use App\Events\ItemToDeleteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterItemIdInSession
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
     * @param  ItemToDeleteEvent  $event
     * @return void
     */
    public function handle(ItemToDeleteEvent $event)
    {
        session([$event->getAction() => $event->getIds()]);
        dd(session($event->getAction()));
        
        
    }
}
