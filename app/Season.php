<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = ['name', 'start_year', 'end_year'];

    public function leagues()
    {
        return $this->belongsToMany('League', 'league_season', 'season_id', 'league_id');
    }
}
