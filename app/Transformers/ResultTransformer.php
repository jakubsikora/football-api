<?php

namespace App\Transformers;

class ResultTransformer extends Transformer {

    /**
     * Transform a result
     *
     * @param  [type] $result [description]
     * @return [type]           [description]
     */
    public function transform($result)
    {
        return [
            'id' => $result['id'],
            'league_id' => $result['league_id'],
            'home_team_id' => $result['home_team_id'],
            'away_team_id' => $result['away_team_id'],
            'ft_home_goals' => $result['ft_home_goals'],
            'ft_away_goals' => $result['ft_away_goals'],
            'ft_result' => $result['ft_result'],
        ];
    }
}