<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    protected $fillable = ['name'];

    public function seasons()
    {
        return $this->belongsToMany('App\Season', 'league_season', 'league_id', 'season_id');
    }

    public function scopeSeason($query, $seasons)
    {
        return $query->whereHas('seasons', function($query) use ($seasons) {
            return $query->whereIn('season_id', (array)$seasons);
        });
    }
}
