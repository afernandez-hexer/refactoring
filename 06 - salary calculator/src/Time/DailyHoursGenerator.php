<?php

namespace App\Time;

use App\Clickup\Timer;
use App\Entity\DailyHours;
use App\Repository\UserRepository;
use App\Time\PeriodToHoursCalculator;

class DailyHoursGenerator
{
    private $timer;

    private $periodToHoursCalculator;

    public function __construct(Timer $timer, PeriodToHoursCalculator $periodToHoursCalculator)
    {
        $this->timer = $timer;

        $this->periodToHoursCalculator = $periodToHoursCalculator;
    }

    public function generate(\DateTime $day): array
    {
        $results = [];

        $periods = $this->timer->getTimesByUserAndDay($day);

        if (is_array($periods) && count($periods) > 0) {
            foreach ($periods as $period) {
                $userEmail = $period["user_email"];
                $startTime = new \DateTime($period['start_date']);
                $endTime = new \DateTime($period['end_date']);

                $existADailyHoursForThatUser = isset($results[$userEmail]);

                if (!$existADailyHoursForThatUser) {
                    $results[$userEmail] = $this->generateDailyHours($userEmail, $day);
                }

                $results[$userEmail]->hoursWorked += $this->periodToHoursCalculator->calculate($startTime, $endTime);
            }
        }

        return $results;
    }

    private function generateDailyHours(string $userEmail, \DateTime $day): DailyHours
    {
        $dailyHours = new DailyHours();
        $dailyHours->day = $day;
        $dailyHours->userEmail = $userEmail;
        $dailyHours->hoursWorked = 0;

        return $dailyHours;
    }
}