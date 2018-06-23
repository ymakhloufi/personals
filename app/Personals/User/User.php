<?php

namespace Personals\User;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Personals\User\User
 *
 * @property integer             $id
 * @property string              $name
 * @property string              $email
 * @property string|null         $password
 * @property string|null         $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['password'];
    protected $hidden  = ['password', 'remember_token'];
}
