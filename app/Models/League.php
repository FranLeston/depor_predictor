<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id', 'name', 'type', 'country','season_start','season_end', 'logo','flag','is_active'
    ];

    /**
     * Get the predictions for the user.
     */
    public function fixtures()
    {
        return $this->hasMany('App\Models\Fixtures');
    }
}
