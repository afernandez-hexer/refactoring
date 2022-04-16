<?php

namespace App\Tests;

use App\Clickup\Timer;
use App\Salary\SalaryGenerator;
use App\Salary\SalaryCalculator;
use App\Tests\Clickup\FakeTimer;
use App\Time\DailyHoursGenerator;
use App\Repository\UserRepository;
use App\Repository\SalaryRepository;
use App\Time\DatesInAMonthGenerator;
use App\Time\PeriodToHoursCalculator;
use App\Salary\SalaryOvertimeCalculator;
use App\Tests\Repository\InMemoryUserRepository;
use App\Tests\Repository\InMemorySalaryRepository;

class Container
{
    private $objects = [];

    public function get(string $class)
    {
        return $this->objects[$class];
    }

    public function add(string $class, $object)
    {
        $this->objects[$class] = $object;
    }

    public static function start()
    {
        $container = new Container();

        $container->add(Timer::class, new FakeTimer());

        $container->add(PeriodToHoursCalculator::class, new PeriodToHoursCalculator());
        $container->add(DatesInAMonthGenerator::class, new DatesInAMonthGenerator());
        $container->add(DailyHoursGenerator::class, new DailyHoursGenerator(
            $container->get(Timer::class),
            $container->get(PeriodToHoursCalculator::class)
        ));

        $container->add(SalaryRepository::class, new InMemorySalaryRepository());
        $container->add(UserRepository::class, new InMemoryUserRepository());
        $container->get(UserRepository::class)->loadFixtures();

        $container->add(SalaryGenerator::class, new SalaryGenerator(
            $container->get(UserRepository::class)
        ));
        $container->add(SalaryOvertimeCalculator::class, new SalaryOvertimeCalculator(
            $container->get(DatesInAMonthGenerator::class),
            $container->get(DailyHoursGenerator::class)
        ));
        $container->add(SalaryCalculator::class, new SalaryCalculator(
            $container->get(SalaryGenerator::class),
            $container->get(SalaryOvertimeCalculator::class),
            $container->get(SalaryRepository::class)  
        ));

        return $container;
    }
}