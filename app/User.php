<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'cpf','password','nivel'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function accesses()
    {
        return $this->hasMany(Access::class);
    }

    public function registerAccess()
    {
        return $this->accesses()->create([
            'user_id' => $this->id,
            'datetime' => date('YmdHis'),
            'type' => 'LOGIN',
            'description' =>'O usuário '. $event->user->name .' entrou no sistema!'
        ]);
    }
}
