<?php

namespace App\Entity;

use App\Entity\User;

class DailyHours
{
    public \DateTime $day;

    public int $hoursWorked;

    public string $userEmail;
}