<?php

namespace App\Tests\Time;

use PHPUnit\Framework\TestCase;
use App\Time\DatesInAMonthGenerator;

class DatesInAMonthGeneratorTest extends TestCase
{
    public function testGenerateReturnsArrayWithDates()
    {
        $sut = $this->createSUT();
        
        $result = $sut->generate('2022-01');
        
        $this->assertTrue(is_array($result));
        $this->assertCount(31, $result);
        $this->assertTrue($result[0] instanceof \DateTime);
    }

    public function testGenerateReturns28DaysInFebruary()
    {
        $sut = $this->createSUT();
        
        $result = $sut->generate('2022-02');
        
        $this->assertTrue(is_array($result));
        $this->assertCount(28, $result);
        $this->assertEquals("2022-02-01", $result[0]->format('Y-m-d'));
        $this->assertEquals("2022-02-28", $result[27]->format('Y-m-d'));
    }

    private function createSUT()
    {
        return new DatesInAMonthGenerator();
    }
}