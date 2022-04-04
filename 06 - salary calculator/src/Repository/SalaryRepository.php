<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Salary;

interface SalaryRepository
{
    public function save(Salary $salary): void;

    /**
     * Devuelve un array de objectos Salary
     */
    public function findSalariesByUser(User $user): array;

    public function findSalaryByUserAndDate(User $user, \DateTime $date): Salary;
}