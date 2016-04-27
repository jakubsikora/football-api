<?php

namespace App;

use App\QueryFilter;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = ['home_team_id', 'away_team_id', 'season_id', 'league_id', 'home_goals', 'away_goals', 'winner'];

    protected $with = ['homeTeam', 'awayTeam', 'season', 'league'];

    public function homeTeam()
    {
        return $this->hasOne('App\Team', 'id', 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->hasOne('App\Team', 'id', 'away_team_id');
    }

    public function season()
    {
        return $this->hasOne('App\Season', 'id', 'season_id');
    }

    public function league()
    {
        return $this->hasOne('App\League', 'id', 'league_id');
    }

    public function scopeFilter($query, QueryFilter $filters)
    {
        return $filters->apply($query);
    }
}
