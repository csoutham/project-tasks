<?php

namespace App\Services;

use App\Models\Task;

class TaskService extends FirebaseService
{
	public function getTasks($sortField = 'title', $shallow = false, array $filters = [])
	{
		$tasks = $this->database->getReference(Task::getCollectionName());
		$collection = collect();

		if ($tasks->getSnapshot()->getValue()) {
			if ($shallow) {
				foreach ($tasks->shallow()->getSnapshot()->getValue() as $id => $bool) {
					$collection->push($id);
				}
			} else {
				$tasks = $tasks->orderByChild($sortField);

				foreach ($filters as $name => $value) {
					$tasks = $tasks->$name($value);
				}

				foreach ($tasks->getSnapshot()->getValue() as $id => $task) {
					$collection->push(Task::create($task + ['fid' => $id]));
				}
			}
		}

		return $collection;
	}

	public function createTask($data)
	{
		$data->created_at = carbon()->now();
		$data->updated_at = carbon()->now();

		$this->database->getReference(Task::getCollectionName())->push($data);
	}
}
