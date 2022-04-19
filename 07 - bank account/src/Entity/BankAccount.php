<?php

namespace App\Entity;

class BankAccount
{
    public string $iban;

    public string $organization;

    public string $office;

    public string $controlDigit;

    public string $accountNumber;

    public ?string $swift;
}