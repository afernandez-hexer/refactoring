<?php

namespace App\Repository;

use App\Entity\Customer;

interface CustomerRepository
{
    public function store(Customer $customer): void;

    public function find(string $id): ?Customer;

    public function findByBirthday(\DateTime $date): array;
}