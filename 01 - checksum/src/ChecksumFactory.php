<?php 

namespace App;

class ChecksumFactory
{
	public function checksum($file)
	{
		if (file_exists($file)) {
			return hash_file('sha256', $file);
		} else {
			throw new \Exception('La ruta interna hacia el fichero no parece correcta.');
		}
	}
}