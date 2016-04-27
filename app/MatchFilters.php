<?php

namespace App;

use App\QueryFilter;

class MatchFilters extends QueryFilter
{
    public function leagues($leagues) // matches?leagues=E0,E1,E2
    {
        $leagueCodes = explode(",", $leagues);

        return $this->builder->whereHas('league', function($query) use ($leagueCodes) {
            $query->whereIn('code', $leagueCodes);
        });
    }

    public function seasons($seasons) // matches?seasons=2015
    {
        $startYears = explode(",", $seasons);

        return $this->builder->whereHas('season', function($query) use ($startYears) {
            $query->whereIn('start_year', $startYears);
        });
    }
}