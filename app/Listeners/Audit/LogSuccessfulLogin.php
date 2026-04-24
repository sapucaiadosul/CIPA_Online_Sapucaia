<?php

namespace App\Listeners\Audit;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use App\Access;

class LogSuccessfulLogin
{

    public function __construct()
    {
        //
    }


    public function handle($event)
    {
        \App\Access::create([
            'user_id' => $event->user->id, 
            'type' => 'LOGIN',
            'description' =>'O usário '. $event->user->name .' entrou no sistema!'
        ]);
    }
}
