<?php

namespace App\Salary;

use App\Salary\SalaryGenerator;
use App\Repository\SalaryRepository;
use App\Salary\SalaryOvertimeCalculator;

class SalaryCalculator
{
    private $salaryGenerator;

    private $overtimeCalculator;

    private $salaryRepository;

    public function __construct(
        SalaryGenerator $salaryGenerator, 
        SalaryOvertimeCalculator $overtimeCalculator,
        SalaryRepository $salaryRepository
    ) {
        $this->salaryGenerator = $salaryGenerator;

        $this->overtimeCalculator = $overtimeCalculator;

        $this->salaryRepository = $salaryRepository;
    }

    public function calculateSalaries(string $month): void
    {
        $salaries = $this->salaryGenerator->generate($month);

        $salaries = $this->overtimeCalculator->calculateOvertime($month, $salaries);

        if (count($salaries) > 0) {
            foreach ($salaries as $salary) {
                $this->salaryRepository->save($salary);
            }
        }
    }
}