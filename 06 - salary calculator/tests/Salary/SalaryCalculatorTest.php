<?php

namespace App\Tests\Salary;

use App\Tests\Container;
use PHPUnit\Framework\TestCase;
use App\Salary\SalaryCalculator;
use App\Repository\UserRepository;
use App\Repository\SalaryRepository;

class SalaryCalculatorTest extends TestCase
{
    public function testCalculateSalaries()
    {
        $container = Container::start();
        $userRepository = $container->get(UserRepository::class);
        $salaryRepository = $container->get(SalaryRepository::class);

        $userRober = $userRepository->findWorkerByEmail('rober@domain.com');
        $userAmalia = $userRepository->findWorkerByEmail('amalia@domain.com');

        $month = "2022-01";

        $this->assertCount(0, $salaryRepository->findSalariesByUser($userRober));
        $this->assertCount(0, $salaryRepository->findSalariesByUser($userAmalia));

        $sut = $container->get(SalaryCalculator::class);

        $sut->calculateSalaries($month);

        $this->assertCount(1, $salaryRepository->findSalariesByUser($userRober));
        $this->assertCount(1, $salaryRepository->findSalariesByUser($userAmalia));

        $executionDay = new \DateTime($month . '-31');

        $salaryRober = $salaryRepository->findSalaryByUserAndDate($userRober, $executionDay);
        $this->assertEquals(820, $salaryRober->salary);
        $this->assertEquals(2, $salaryRober->overtimeHours);

        $salaryAmalia = $salaryRepository->findSalaryByUserAndDate($userAmalia, $executionDay);
        $this->assertEquals(1340, $salaryAmalia->salary);
        $this->assertEquals(4, $salaryAmalia->overtimeHours);
    }
}