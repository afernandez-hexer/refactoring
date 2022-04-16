<?php

namespace App\Tests\Time;

use App\Entity\User;
use App\Clickup\Timer;
use App\Entity\DailyHours;
use PHPUnit\Framework\TestCase;
use App\Time\DailyHoursGenerator;
use App\Time\PeriodToHoursCalculator;
use App\Tests\Repository\InMemoryUserRepository;

class DailyHoursGeneratorTest extends TestCase
{
    public function testGenerateReturnsArrayOfDailyHours()
    {
        $date = new \DateTime("2022-01-03");

        $sut = $this->createSUT();

        $result = $sut->generate($date);

        $this->assertTrue(is_array($result));
        $this->assertTrue($result['rober@domain.com'] instanceof DailyHours);
    }

    public function testGenerateReturnsCalculatedDailyHours()
    {
        $date = new \DateTime("2022-01-03");

        $sut = $this->createSUT();

        $result = $sut->generate($date);

        $this->assertTrue(is_array($result));
        $this->assertCount(2, $result);

        $this->assertEquals(2, $result['rober@domain.com']->hoursWorked);
        $this->assertEquals('2022-01-03', $result['rober@domain.com']->day->format('Y-m-d'));

        $this->assertEquals(1, $result['amalia@domain.com']->hoursWorked);
        $this->assertEquals('2022-01-03', $result['amalia@domain.com']->day->format('Y-m-d'));
    }

    private function createSUT()
    {
        $periodCalculator = $this->createPeriodCalculator();

        $timer = $this->createTimer();

        return new DailyHoursGenerator(
            $timer,
            $periodCalculator
        );
    }

    private function createPeriodCalculator()
    {
        $periodCalculator = $this->createMock(PeriodToHoursCalculator::class);
        $periodCalculator
            ->method('calculate')
            ->will($this->returnValue(1))
        ;

        return $periodCalculator;
    }

    private function createTimer()
    {
        $periods = [
            [
                "user_email" => "rober@domain.com",
                "start_date" => "2022-01-03 10:03:12",
                "end_date" => "2022-01-03 10:32:59",
            ],[
                "user_email" => "rober@domain.com",
                "start_date" => "2022-01-03 12:12:12",
                "end_date" => "2022-01-03 14:00:00",
            ],[
                "user_email" => "amalia@domain.com",
                "start_date" => "2022-01-03 08:00:00",
                "end_date" => "2022-01-03 14:00:00",
            ]
        ];

        $timer = $this->createMock(Timer::class);
        $timer
            ->method('getTimesByUserAndDay')
            ->will($this->returnValue($periods))
        ;

        return $timer;
    }
}