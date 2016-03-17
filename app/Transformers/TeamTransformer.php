<?php

namespace App\Transformers;

class TeamTransformer extends Transformer {

    /**
     * Transform a team
     *
     * @param  [type] $team [description]
     * @return [type]           [description]
     */
    public function transform($team)
    {
        return [
            'id' => $team['id'],
            'name' => $team['name'],
        ];
    }
}