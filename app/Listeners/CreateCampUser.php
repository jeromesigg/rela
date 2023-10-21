<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Camp;
use App\Models\CampUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateCampUser
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
     * @param  \App\Events\UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        //
        $camp = Camp::where('global_camp', true)->first();
        $camp_user = CampUser::firstOrCreate(['camp_id' => $camp['id'], 'user_id' => $event->user['id']]);
        $camp_user->update([
            'role_id' => config('status.role_Teilnehmer'),
        ]);
        if (! $event->user->camp) {
            $event->user->update([
                'camp_id' => $camp['id'],
            ]);
        }
        if (! $event->user->role) {
            $event->user->update([
                'role_id' => config('status.role_Teilnehmer'),
            ]);
        }
    }
}
