<?php

namespace App\System;

class ClockService
{
    public function today(): \DateTime
    {
        return new \DateTime('NOW');
    }
}