<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;

class InMemoryUserRepository implements UserRepository
{
    private $users = [];

    public function save(User $user): void
    {
        $this->users[$user->email] = $user;
    }

    /**
     * Devuelve un array de objectos User
     */
    public function findWorkers() : array
    {
        return array_values($this->users);
    }

    public function findWorkerByEmail(string $email) : User
    {
        if (!isset($this->users[$email])) {
            throw new \RuntimeException("User not found!");
        }

        return $this->users[$email];
    }

    public function loadFixtures()
    {
        $user = new User();
        $user->name = 'Roberto';
        $user->email = 'rober@domain.com';
        $user->hoursPerDay = 5;
        $user->monthlySalary = 800;
        $user->overtimeSalaryPerHour = 10;

        $this->save($user);

        $user = new User();
        $user->name = 'Amalia';
        $user->email = 'amalia@domain.com';
        $user->hoursPerDay = 8;
        $user->monthlySalary = 1300;
        $user->overtimeSalaryPerHour = 10;

        $this->save($user);
    }
}