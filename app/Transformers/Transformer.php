<?php

namespace App\Transformers;

abstract class Transformer {

    /**
     * Transform items
     *
     * @param  [type] $items [description]
     * @return [type]            [description]
     */
    public function transformCollection(array $items)
    {
        return array_map([$this, 'transform'], $items);
    }

    public abstract function transform($item);
}