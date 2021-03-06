<?php

use App\ChecksumFactory;
use PHPUnit\Framework\TestCase;

class ChecksumFactoryTest extends TestCase
{
    public function testChecksumReturnsSha256IfFileExists()
    {
        $file = $this->getTestFile();
        $expectedChecksum = $this->getTestChecksum();

        $sut = $this->createSUT();

        $result = $sut->checksum($file);

        $this->assertTrue(is_string($result));
        $this->assertEquals($expectedChecksum, $result);
    }

    public function testChecksumThrowExceptionIfFileDoesntExist()
    {
        $this->expectException(\Exception::class);

        $notExistingFile = 'not-existing-file.txt';

        $sut = $this->createSUT();

        $sut->checksum($notExistingFile);        
    }

    private function createSUT()
    {
        return new ChecksumFactory();
    }

    private function getTestFile()
    {
        return __DIR__ . '/test-file.txt';
    }

    private function getTestChecksum()
    {
        return 'd039d9004971ab62ad3046e3822cd379c0713c1d60ebbbaa7de2b237dd698719';
    }
}