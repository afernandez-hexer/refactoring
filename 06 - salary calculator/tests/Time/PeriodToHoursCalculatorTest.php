<?php

namespace App\Tests\Time;

use PHPUnit\Framework\TestCase;
use App\Time\PeriodToHoursCalculator;

class PeriodToHoursCalculatorTest extends TestCase
{
    public function testCalculateReturnsInteger()
    {
        $startTime = new \DateTime('2022-01-01 14:01:00');
        $endTime = new \DateTime('2022-01-01 16:46:35');

        $sut = $this->createSUT();

        $result = $sut->calculate($startTime, $endTime);

        $this->assertTrue(is_integer($result));
    }

    public function testCalculateThrowExceptionIfStartTimeGreaterThanEndTime()
    {
        $this->expectException(\RuntimeException::class);

        $startTime = new \DateTime('2022-01-02 14:01:00');
        $endTime = new \DateTime('2022-01-01 16:46:35');

        $sut = $this->createSUT();

        $result = $sut->calculate($startTime, $endTime);
    }

    /**
     * @dataProvider getTestData
     */
    public function testCalculateReturnExpectedHours($startTime, $endTime, $expectedHours)
    {
        $sut = $this->createSUT();

        $result = $sut->calculate($startTime, $endTime);

        $this->assertEquals($expectedHours, $result);
    }

    public function getTestData()
    {
        return [
            '0 hours' => [new \DateTime('2022-01-01 13:00:00'), new \DateTime('2022-01-01 13:00:00'), 0],
            'exactly hours' => [new \DateTime('2022-01-01 13:00:00'), new \DateTime('2022-01-01 15:00:00'), 2],
            'round down' => [new \DateTime('2022-01-01 13:00:00'), new \DateTime('2022-01-01 15:01:00'), 2],
            'round up' => [new \DateTime('2022-01-01 13:00:00'), new \DateTime('2022-01-01 15:55:00'), 3],
            'more than a day' => [new \DateTime('2022-01-01 13:00:00'), new \DateTime('2022-01-02 15:00:00'), 26],
            'more than a month' => [new \DateTime('2022-01-01 13:00:00'), new \DateTime('2022-02-02 15:00:00'), 770],
        ];
    }

    private function createSUT()
    {
        return new PeriodToHoursCalculator();
    }
}