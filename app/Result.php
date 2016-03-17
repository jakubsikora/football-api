<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['league_id', 'date', 'home_team_id', 'away_team_id',
        'ft_home_goals', 'ft_away_goals', 'ft_result', 'ht_home_goals',
        'ht_away_goals', 'ht_result', 'referee'];
}
