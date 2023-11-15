<?php

namespace backend\services;

class RandDateTime
{
    private $start;
    private $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function getRand()
    {
        return mt_rand($this->start, $this->end);
    }
}