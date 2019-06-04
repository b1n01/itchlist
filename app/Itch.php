<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itch extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pic', 'description', 'price', 'seller', 'user_id', 'provider',
    ];

    protected $hidden = [];

    /**
     * Get the user that owns the Itch.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the user that owns the Itch.
     */
    public function bookedBy()
    {
        return $this->belongsTo('App\User');
    }
}
