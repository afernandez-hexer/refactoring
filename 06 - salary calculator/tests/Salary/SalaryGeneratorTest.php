<?php

namespace App\Tests\Salary;

use App\Entity\User;
use App\Entity\Salary;
use App\Salary\SalaryGenerator;
use PHPUnit\Framework\TestCase;
use App\Tests\Repository\InMemoryUserRepository;

class SalaryGeneratorTest extends TestCase
{
    public function testGenerateReturnsAssociatedArrayByUserEmail()
    {
        $sut = $this->createSUT();
        $result = $sut->generate("2022-01");

        $this->assertTrue(is_array($result));
        $this->assertCount(2, $result);
        $this->assertTrue(isset($result["rober@domain.com"]));
        $this->assertTrue(isset($result["amalia@domain.com"]));
        $this->assertTrue($result["amalia@domain.com"] instanceof Salary);        
    }

    public function testGenerateReturnsBaseSalary()
    {
        $sut = $this->createSUT();
        $result = $sut->generate("2022-01");

        $this->assertEquals("amalia@domain.com", $result["amalia@domain.com"]->user->email);
        $this->assertEquals("2022-01", $result["amalia@domain.com"]->month);
        $this->assertEquals(1300, $result["amalia@domain.com"]->salary);
        $this->assertEquals(0, $result["amalia@domain.com"]->overtimeHours);

        $this->assertEquals("rober@domain.com", $result["rober@domain.com"]->user->email);
        $this->assertEquals("2022-01", $result["rober@domain.com"]->month);
        $this->assertEquals(800, $result["rober@domain.com"]->salary);
        $this->assertEquals(0, $result["rober@domain.com"]->overtimeHours);
    }

    private function createSUT()
    {
        $userRepository = $this->createUserRepository();

        return new SalaryGenerator($userRepository);
    }

    private function createUserRepository()
    {
        $repository = new InMemoryUserRepository();
        $repository->loadFixtures();

        return $repository;
    }
}