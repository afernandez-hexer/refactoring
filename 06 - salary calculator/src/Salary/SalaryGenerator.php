<?php

namespace App\Salary;

use App\Entity\User;
use App\Entity\Salary;
use App\Repository\UserRepository;

class SalaryGenerator
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function generate($month)
    {
        $results = [];

        $users = $this->userRepository->findWorkers();

        if (count($users) > 0) {
            foreach ($users as $user) {
                $results[$user->email] = $this->createSalary($month, $user);
            }
        }

        return $results;
    }

    private function createSalary(string $month, User $user): Salary
    {
        $salary = new Salary();
        $salary->user = $user;
        $salary->month = $month;
        $salary->salary = $user->monthlySalary;
        $salary->overtimeHours = 0;

        return $salary;
    }
}