<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fixture_id', 'league_id', 'event_date', 'event_timestamp', 'round','status','home_team_id','away_team_id',
        'goals_home_team', 'goals_away_team'
    ];
}
