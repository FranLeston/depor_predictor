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
        'fixture_id', 'league_id', 'event_date', 'event_timestamp', 'round', 'is_current', 'status', 'home_team_id', 'away_team_id',
        'goals_home_team', 'goals_away_team',
    ];

    /**
     * Get the post that owns the comment.
     */
    public function league()
    {
        return $this->belongsTo('App\Models\League');
    }

    /**
     * Get the post that owns the comment.
     */
    public function homeTeam()
    {
        return $this->belongsTo('App\Models\Team', 'home_team_id', 'team_id');

    }

    /**
     * Get the post that owns the comment.
     */
    public function awayTeam()
    {
        return $this->belongsTo('App\Models\Team', 'away_team_id', 'team_id');

    }

    /**
     * Get the predictions for the user.
     */
    public function predictions()
    {
        return $this->hasMany('App\Models\Prediction', 'fixture_id', 'fixture_id');
    }

}
