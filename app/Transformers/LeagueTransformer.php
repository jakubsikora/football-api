<?php

namespace App\Transformers;

class LeagueTransformer extends Transformer {

    /**
     * Transform a league
     *
     * @param  [type] $league [description]
     * @return [type]           [description]
     */
    public function transform($league)
    {
        return [
            'id' => $league['id'],
            'code' => $league['code'],
            'name' => $league['name'],
        ];
    }
}