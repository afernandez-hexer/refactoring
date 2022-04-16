<?php

namespace App\Salary;

use App\Time\DailyHoursGenerator;
use App\Time\DatesInAMonthGenerator;

class SalaryOvertimeCalculator
{
    private $datesGenerator;

    private $dailyHoursGenerator;

    public function __construct(
        DatesInAMonthGenerator $datesGenerator,
        DailyHoursGenerator $dailyHoursGenerator
    ) {
        $this->datesGenerator = $datesGenerator;
    
        $this->dailyHoursGenerator = $dailyHoursGenerator;
    }

    public function calculateOvertime(string $month, array $salaries): array
    {
        $dates = $this->datesGenerator->generate($month);

        foreach ($dates as $date) {
            $dailyHours = $this->dailyHoursGenerator->generate($date);

            if (count($dailyHours) > 0) {
                foreach ($dailyHours as $dailyHoursPerUser) {
                    $salary = $salaries[$dailyHoursPerUser->userEmail];

                    $hoursPerDay = $salary->user->hoursPerDay;
                    $overtimeSalaryPerHour = $salary->user->overtimeSalaryPerHour;

                    $overtimeHours = $dailyHoursPerUser->hoursWorked - $hoursPerDay;

                    if ($overtimeHours > 0) {
                        $salary->salary += $overtimeHours * $overtimeSalaryPerHour;
                        $salary->overtimeHours += $overtimeHours;    
                    }
                }
            }
        }

        return $salaries;
    }
}