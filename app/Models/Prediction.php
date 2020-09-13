<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'fixture_id', 'home_team_prediction', 'away_team_prediction', 'points',
    ];

    /**
     * Get the user that owns the prediction.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the predictions for the user.
     */
    public function fixture()
    {
        return $this->belongsTo('App\Models\Fixture', 'fixture_id', 'fixture_id');
    }
}
