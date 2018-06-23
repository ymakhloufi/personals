<?php

namespace Personals\User;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['password'];
    protected $hidden  = ['password', 'remember_token'];
}
