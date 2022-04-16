<?php

namespace App\Time;

class PeriodToHoursCalculator
{
    public function calculate(\DateTime $startTime, \DateTime $endTime): int
    {
        if ($startTime > $endTime) {
            throw new \RuntimeException("La fecha de inicio no debe ser superior a la fecha de fin");
        }

        $timeDifference = $startTime->diff($endTime);

        $hours = 0;

        $hours += $timeDifference->days * 24;

        $hours += $timeDifference->h;

        if ($timeDifference->i >= 30) {
            $hours++;
        }

        return $hours;
    }
}