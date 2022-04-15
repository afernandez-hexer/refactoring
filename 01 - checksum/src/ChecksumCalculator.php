<?php 

namespace App;

class ChecksumCalculator
{
	public function calculateChecksum(string $pathToFile)
	{
		if (!file_exists($pathToFile)) {
			throw new \Exception('La ruta interna hacia el fichero no parece correcta.');
		}

		return hash_file('sha256', $pathToFile);
	}
}