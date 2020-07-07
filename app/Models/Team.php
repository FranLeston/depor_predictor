<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id','name', 'logo', 'country', 'is_national', 'venue_city', 'venue_name'
    ];
    /**
     * Get the predictions for the user.
     */
    // public function fixtures()
    // {
    //     return $this->hasMany('App\Models\Fixtures', 'home_team_id', 'team_id' );
    // }
}
