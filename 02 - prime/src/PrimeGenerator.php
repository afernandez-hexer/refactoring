<?php 

namespace App;

class PrimeGenerator
{
	public function nextPrimeFrom(int $number): int
	{
		if ($number<1) {
			throw new \RuntimeException("Bad parameter");
		}

		do {
			$number++;
		} while (!$this->isPrime($number));

		return $number;
	}

	private function isPrime(int $number): bool
	{
		$maxDivisor = (int) floor(sqrt($number));
			
		for ($i = 2; $i <= $maxDivisor; $i++) {
			$isDivisible = ($number % $i == 0);

			if ($isDivisible) {
				return false;
			}
		}

		return true;
	}
}