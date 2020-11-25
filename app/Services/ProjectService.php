<?php

namespace App\Services;

use App\Models\Project;

class ProjectService extends FirebaseService
{
	public function getProjects($sortField = 'name', $shallow = false, array $filters = [])
	{
		$projects = $this->database->getReference(Project::getCollectionName());
		$collection = collect();

		if ($projects->getSnapshot()->getValue()) {
			if ($shallow) {
				foreach ($projects->shallow()->getSnapshot()->getValue() as $id => $bool) {
					$collection->push($id);
				}
			} else {
				$projects = $projects->orderByChild($sortField);

				foreach ($filters as $name => $value) {
					$projects = $projects->$name($value);
				}

				foreach ($projects->getSnapshot()->getValue() as $id => $project) {
					$collection->push(Project::create($project + ['fid' => $id]));
				}
			}
		}

		return $collection;
	}

	public function createProject($data)
	{
		$data->created_at = carbon()->now();
		$data->updated_at = carbon()->now();

		$this->database->getReference(Project::getCollectionName())->push($data);
	}
}
