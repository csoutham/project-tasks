<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Services\ClientService;
use App\Services\ProjectService;
use Livewire\WithPagination;

class ProjectsTable extends LivewireHelper
{
	use WithPagination;

	public $perPage = 30;
	public $sortField = 'name';
	public $sortAsc = true;
	public $client = null;
	public $status = Project::STATUS_LIVE;

	protected $queryString = ['client', 'status'];

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

	public function render(ClientService $clientService, ProjectService $projectService)
	{
		$clients = $clientService->getClients();
		$statuses = Project::STATUSES;

		$projects = $projectService->getProjects();

		$projects = $projectService->filterBy($projects, 'client_id', $this->client);
		$projects = $projectService->filterBy($projects, 'status', $this->status);
		$projects = ($this->sortAsc) ? $projects->sortBy($this->sortField) : $projects->sortByDesc($this->sortField);

		$projects = $this->paginateCollection($projects, $this->perPage);

		return view('livewire.projects-table')->with([
			'clients' => $clients,
			'projects' => $projects,
			'statuses' => $statuses,
		]);
	}

	public function paginationView()
	{
		return 'components.pagination';
	}
}
