<?php

namespace App\Services;

use App\Models\Client;

class ClientService extends FirebaseService
{
	public function getClients($sortField = 'name', $shallow = false, array $filters = [])
	{
		$clients = $this->database->getReference(Client::getCollectionName());
		$collection = collect();

		if ($clients->getSnapshot()->getValue()) {
			if ($shallow) {
				foreach ($clients->shallow()->getSnapshot()->getValue() as $id => $bool) {
					$collection->push($id);
				}
			} else {
				$clients = $clients->orderByChild($sortField);
				
				foreach ($filters as $name => $value) {
					$clients = $clients->$name($value);
				}
				
				foreach ($clients->getSnapshot()->getValue() as $id => $client) {
					$collection->push(Client::create($client + ['fid' => $id]));
				}
			}
		}

		return $collection;
	}

	public function createClient($data)
	{
		$data->created_at = carbon()->now();
		$data->updated_at = carbon()->now();

		$this->database->getReference(Client::getCollectionName())->push($data);
	}
}
