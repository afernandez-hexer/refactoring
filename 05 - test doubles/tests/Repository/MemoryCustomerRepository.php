<?php

namespace App\Tests\Repository;

use App\Entity\Customer;
use App\Repository\CustomerRepository;

class MemoryCustomerRepository implements CustomerRepository
{
    private array $customers = [];

	public function store(Customer $customer): void
	{
		$this->customers[$customer->id] = $customer;
	}

	public function find(string $customerId): ?Customer
	{
		return isset($this->customers[$customerId])
            ? $this->customers[$customerId]
            : null
        ;
	}

	public function findByBirthday(\DateTime $currentDate): array
	{
		$result = [];

        if (count($this->customers) > 0) {
            foreach ($this->customers as $customer) {
                if ($customer->birthday->format('m-d') == $currentDate->format('m-d')) {
                    $result[] = $customer;
                }
            }
        }


        return $result;
	}
}