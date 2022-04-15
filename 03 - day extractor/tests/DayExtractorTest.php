<?php

use App\DayExtractor;
use PHPUnit\Framework\TestCase;

class DayExtractorTest extends TestCase
{
    public function testExtractReturnsArrayOfDates()
    {
        $startDate = new \DateTime('2022-01-01');
        $endDate = new \DateTime('2022-01-02');

        $sut = $this->createSUT();

        $result = $sut->extract($startDate, $endDate);

        $this->assertTrue(is_array($result));
        $this->assertCount(2, $result);
        $this->assertTrue($result[0] instanceof \DateTime);
    }

    public function testExtractReturnsCorrectDatesBetweenMonths()
    {
        $startDate = new \DateTime('2022-01-30');
        $endDate = new \DateTime('2022-02-03');

        $sut = $this->createSUT();

        $result = $sut->extract($startDate, $endDate);

        $this->assertTrue(is_array($result));
        $this->assertCount(5, $result);
        $this->assertEquals('2022-01-30', $result[0]->format('Y-m-d'));
        $this->assertEquals('2022-01-31', $result[1]->format('Y-m-d'));
        $this->assertEquals('2022-02-01', $result[2]->format('Y-m-d'));
        $this->assertEquals('2022-02-02', $result[3]->format('Y-m-d'));
        $this->assertEquals('2022-02-03', $result[4]->format('Y-m-d'));
    }

    public function testExtractReturnsEmptyArrayWithStartDateGreaterThanEndDate()
    {
        $startDate = new \DateTime('2022-02-03');
        $endDate = new \DateTime('2022-01-30');

        $sut = $this->createSUT();

        $result = $sut->extract($startDate, $endDate);

        $this->assertTrue(is_array($result));
        $this->assertCount(0, $result);
    }

    private function createSUT()
    {
        return new DayExtractor();
    }
}