<?php

use PHPUnit\Framework\TestCase;
use App\AvailabilityStringToArray;

class AvailabilityStringToArrayTest extends TestCase
{
    public function testTransformThrowExceptionIfStringHasLessThan30Positions()
    {
        $this->expectException(\RuntimeException::class);

        $stringToTransform = '00000';   

        $sut = $this->createSUT();
        $sut->transform($stringToTransform);
    }

    public function testTransformThrowExceptionIfOnePositionIsNotANumber()
    {
        $this->expectException(\RuntimeException::class);

        $stringToTransform = '0000000000000A000000000000000000';   

        $sut = $this->createSUT();
        $sut->transform($stringToTransform);
    }

    public function testTransformReturnsArrayWithZeros()
    {
        $stringToTransform = '00000000000000000000000000000000';
        $expectedArray = $this->getEmptyArray();

        $sut = $this->createSUT();
        $result = $sut->transform($stringToTransform);

        $this->assertTrue(is_array($result));
        $this->assertCount(32, $result);
        $this->assertEquals($expectedArray, $result);
    }

    public function testTransformReturnsArrayWithAvailability()
    {
        $stringToTransform = '12345678901234567890123456789012';
        $expectedArray = $this->getAvailabilityArray();

        $sut = $this->createSUT();
        $result = $sut->transform($stringToTransform);

        $this->assertTrue(is_array($result));
        
        $this->assertCount(32, $result);
        $this->assertEquals($expectedArray, $result);
    }

    private function createSUT()
    {
        return new AvailabilityStringToArray();
    }

    private function getEmptyArray()
    {
        return [
            '8:00' => 0, '8:30' => 0, '9:00' => 0, '9:30' => 0, '10:00' => 0, '10:30' => 0, '11:00' => 0, '11:30' => 0, '12:00' => 0, '12:30' => 0,
            '13:00' => 0, '13:30' => 0, '14:00' => 0, '14:30' => 0, '15:00' => 0, '15:30' => 0, '16:00' => 0, '16:30' => 0, '17:00' => 0, '17:30' => 0,
            '18:00' => 0, '18:30' => 0, '19:00' => 0, '19:30' => 0, '20:00' => 0, '20:30' => 0, '21:00' => 0, '21:30' => 0, '22:00' => 0, '22:30' => 0, 
            '23:00' => 0, '23:30' => 0
        ];
    }

    private function getAvailabilityArray()
    {
        return [
            '8:00' => 1, '8:30' => 2, '9:00' => 3, '9:30' => 4, '10:00' => 5, '10:30' => 6, '11:00' => 7, '11:30' => 8, '12:00' => 9, '12:30' => 0,
            '13:00' => 1, '13:30' => 2, '14:00' => 3, '14:30' => 4, '15:00' => 5, '15:30' => 6, '16:00' => 7, '16:30' => 8, '17:00' => 9, '17:30' => 0,
            '18:00' => 1, '18:30' => 2, '19:00' => 3, '19:30' => 4, '20:00' => 5, '20:30' => 6, '21:00' => 7, '21:30' => 8, '22:00' => 9, '22:30' => 0, 
            '23:00' => 1, '23:30' => 2
        ];
    }
}