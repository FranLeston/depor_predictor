<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id', 'league_name', 'round', 'season_start', 'season_end', 'type', 'is_current',
    ];

    /**
     * Get the fixture that owns the round
     */
    public function fixture()
    {
        return $this->belongsTo('App\Models\Fixture');
    }
}
