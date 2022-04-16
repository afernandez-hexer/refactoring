<?php

namespace App\Time;

class DatesInAMonthGenerator
{
    public function generate(string $month): array
    {
        $dates = [];

        $day = new \DateTime($month . '-01');
        $lastDay = new \DateTime($month . '-' . $day->format('t'));

        while ($day <= $lastDay) {
            $dates[] = clone $day;

            $day->add(new \DateInterval('P1D'));
        }

        return $dates;
    }
}