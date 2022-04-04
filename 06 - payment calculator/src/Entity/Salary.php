<?php

namespace App\Entity;

class Salary
{
    public string $month; //formato YYYY-mm (2022-01)

    public User $user;

    public float $salary;

    public int $overtimeHours;
}