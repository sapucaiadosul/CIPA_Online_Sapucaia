<?php

namespace App\Listeners\Audit;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Logout;
use App\Access;

class LogSuccessfulLogout
{
    public function __construct()
    {
        //
    }

    public function handle($event)
    {
        \App\Access::create([
            'user_id' => $event->user->id, 
            'type' => 'LOGOUT',
            'description' =>'O usário  '. $event->user->name .' saiu do sistema!'
        ]);
    }
}
