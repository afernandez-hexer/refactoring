<?php

namespace App\Tests\Salary;

use App\Entity\User;
use App\Entity\Salary;
use App\Entity\DailyHours;
use PHPUnit\Framework\TestCase;
use App\Time\DailyHoursGenerator;
use App\Time\DatesInAMonthGenerator;
use App\Salary\SalaryOvertimeCalculator;
use App\Tests\Repository\InMemoryUserRepository;

class SalaryOvertimeCalculatorTest extends TestCase
{
    public function testCalculateUpdatesSalaries()
    {
        $userRepository = new InMemoryUserRepository();
        $userRepository->loadFixtures();

        $userRober = $userRepository->findWorkerByEmail('rober@domain.com');
        $userAmalia = $userRepository->findWorkerByEmail('amalia@domain.com');

        $salaries = [
            "rober@domain.com" => $this->createSalary($userRober),
            "amalia@domain.com" => $this->createSalary($userAmalia)
        ];

        $month = "2022-01";

        $sut = $this->createSUT();

        $result = $sut->calculateOvertime($month, $salaries);

        $this->assertTrue(is_array($result));
        $this->assertCount(2, $result);
        $this->assertEquals(1310, $result['amalia@domain.com']->salary);
        $this->assertEquals(820, $result['rober@domain.com']->salary);
    }

    private function createSalary(User $user): Salary
    {
        $salary = new Salary();
        $salary->user = $user;
        $salary->salary = $user->monthlySalary;
        $salary->month = '2022-01';
        $salary->overtimeHours = 0;

        return $salary;
    }

    private function createSUT()
    {
        $datesGenerator = $this->createDatesInAMonthGenerator();
        $dailyHoursGenerator = $this->createDailyHoursGenerator();

        return new SalaryOvertimeCalculator(
            $datesGenerator,
            $dailyHoursGenerator
        );
    }

    private function createDatesInAMonthGenerator()
    {
        $datesGenerator = $this->createMock(DatesInAMonthGenerator::class);

        $dates = [
            new \DateTime('2022-01-03'),
            new \DateTime('2022-01-05'),
        ];

        $datesGenerator
            ->method('generate')
            ->will(
                $this->returnValue($dates)
            )
        ;

        return $datesGenerator;
    }

    private function createDailyHoursGenerator()
    {
        $dailyHoursGenerator = $this->createMock(DailyHoursGenerator::class);

        $dailyHoursGenerator
            ->method('generate')
            ->will(
                $this->returnCallback(function ($date) {
                    $dailyHours = [];

                    if ($date->format('Y-m-d') == '2022-01-03') {
                        $dailyHours[] = $this->createDailyHours($date, 'rober@domain.com', 7);
                        $dailyHours[] = $this->createDailyHours($date, 'amalia@domain.com', 7);
                    } else {
                        $dailyHours[] = $this->createDailyHours($date, 'rober@domain.com', 5);
                        $dailyHours[] = $this->createDailyHours($date, 'amalia@domain.com', 9);
                    }

                    return $dailyHours;
                })
            )
        ;

        return $dailyHoursGenerator;
    }

    private function createDailyHours(\DateTime $date, string $userEmail, int $hoursWorked): DailyHours
    {
        $dailyHours = new DailyHours();
        $dailyHours->userEmail = $userEmail;
        $dailyHours->date = $date;
        $dailyHours->hoursWorked = $hoursWorked;

        return $dailyHours;
    }
}