<?php

use App\PrimeGenerator;
use PHPUnit\Framework\TestCase;

class PrimeGeneratorTest extends TestCase
{
    public function testGenerateThrowsExceptionWithParamLessThanOne()
    {
        $this->expectException(\RuntimeException::class);

        $sut = $this->createSUT();

        $sut->nextPrimeFrom(-2);
    }

    public function testGenerateReturnsTwoIfOneIsPassed()
    {
        $sut = $this->createSUT();

        $result = $sut->nextPrimeFrom(1);

        $this->assertEquals(2, $result);
    }

    /**
     * @dataProvider getTestData
     */
    public function testGenerateReturnsNextPrimeNumber($number, $nextPrime)
    {
        $sut = $this->createSUT();

        $result = $sut->nextPrimeFrom($number);

        $this->assertEquals($nextPrime, $result);
    }

    public function getTestData()
    {
        return [
            'passing 2' => [2, 3],
            'passing 5' => [5, 7],
            'passing 6' => [6, 7],
            'passing 13' => [13, 17]
        ];
    }

    private function createSUT()
    {
        return new PrimeGenerator();
    }
}