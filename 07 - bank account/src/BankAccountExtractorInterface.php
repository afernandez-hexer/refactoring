<?php

namespace App;

use App\Entity\BankAccount;

interface BankAccountExtractorInterface
{
    public function isValidAccount(string $account): bool;

    public function extractBankAccount(string $account): BankAccount;
}