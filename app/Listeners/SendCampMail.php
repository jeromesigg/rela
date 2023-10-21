<?php

namespace App\Listeners;

use App\Events\CampCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCampMail
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
     * @param  \App\Events\CampCreated  $event
     * @return void
     */
    public function handle(CampCreated $event)
    {
        //
    }
}
