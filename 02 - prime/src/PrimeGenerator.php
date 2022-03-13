<?php 

namespace App;

class PrimeGenerator
{
	public function generate($number)
	{
		if ($number<1) {
			throw new \RuntimeException("Bad parameter");
		}

		if ($number == 1) {
			return 2;
		}

		$f = false;

		do {
			$number++;

			$x = (int) floor(sqrt($number));
			
			for ($i = 2; $i <= $x; $i++) {
				if ($number % $i == 0) {
					break;
				}
			}

			if ($x == $i-1) {
				$f = true;
			}

		} while ($f == false);

		return $number;
	}
}