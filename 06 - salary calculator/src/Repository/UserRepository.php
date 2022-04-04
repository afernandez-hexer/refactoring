<?php

namespace App\Repository;

use App\Entity\User;

interface UserRepository
{
    public function save(User $user): void;

    /**
     * Devuelve un array de objectos User
     */
    public function findWorkers() : array;

    public function findWorkerByEmail(string $email) : User;
}