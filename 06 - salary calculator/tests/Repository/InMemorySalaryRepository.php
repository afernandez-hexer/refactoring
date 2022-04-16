<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Entity\Salary;
use App\Repository\SalaryRepository;

class InMemorySalaryRepository implements SalaryRepository
{
    private $salaries = [];

    public function save(Salary $salary): void
    {
        $this->salaries[$salary->user->email][$salary->month] = $salary;
    }

    /**
     * Devuelve un array de objectos Salary
     */
    public function findSalariesByUser(User $user ) : array
    {
        return isset($this->salaries[$user->email]) 
            ? array_values($this->salaries[$user->email])
            : []
        ;
    }

    public function findSalaryByUserAndDate(User $user, \DateTime $date): Salary
    {
        return $this->salaries[$user->email][$date->format('Y-m')];
    }
}