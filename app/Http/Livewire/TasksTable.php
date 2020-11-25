<?php

namespace App\Http\Livewire;

use App\Models\Task;
use App\Services\ProjectService;
use App\Services\TaskService;
use Livewire\WithPagination;

class TasksTable extends LivewireHelper
{
	use WithPagination;

	public $perPage = 30;
	public $sortField = 'title';
	public $sortAsc = true;
	public $project = null;
	public $status = null;

	protected $queryString = ['project', 'status'];

	public function updatingSearch()
	{
		$this->resetPage();
	}

	public function sortBy($field)
	{
		if ($this->sortField === $field) {
			$this->sortAsc = !$this->sortAsc;
		} else {
			$this->sortAsc = true;
		}

		$this->sortField = $field;
	}

	public function render(ProjectService $projectService, TaskService $taskService)
	{
		$projects = $projectService->getProjects();
		$statuses = Task::STATUSES;

		$tasks = $taskService->getTasks();

		$tasks = $taskService->filterBy($tasks, 'project_id', $this->project);
		$tasks = $taskService->filterBy($tasks, 'status', $this->status);
		$tasks = ($this->sortAsc) ? $tasks->sortBy($this->sortField) : $tasks->sortByDesc($this->sortField);

		$tasks = $this->paginateCollection($tasks, $this->perPage);

		return view('livewire.tasks-table')->with([
			'projects' => $projects,
			'tasks' => $tasks,
			'statuses' => $statuses,
		]);
	}

	public function paginationView()
	{
		return 'components.pagination';
	}
}
