<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'pic',
    ];

    protected $hidden = [
        'provider_user_token', 'provider_user_id', 'provider',
    ];

    /**
     * Get the itches of an user
     */
    public function itches()
    {
        return $this->hasMany('App\Itch');
    }

    /**
     * Get the itches of an user
     */
    public function hasBooked()
    {
        return $this->hasMany('App\Itch');
    }
}
