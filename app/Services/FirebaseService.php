<?php

namespace App\Services;

use Kreait\Firebase\Database as FirebaseDatabase;

class FirebaseService
{
	public function __construct(FirebaseDatabase $database)
	{
		$this->database = $database;
	}

	public function filterBy($collection, $column, $value)
	{
		if ((is_null($value) || empty($value)) && $value !== '0') {
			return $collection;
		}

		return $collection->where($column, $value);
	}
}
