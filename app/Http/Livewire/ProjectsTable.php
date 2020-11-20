<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\Project;
use Livewire\WithPagination;

class ProjectsTable extends LivewireHelper
{
	use WithPagination;

	public $perPage = 30;
	public $sortField = 'name';
	public $sortAsc = true;
	public $client = null;
	public $status = Project::STATUS_LIVE;
	public $search = '';

	protected $queryString = ['status'];

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

	public function render()
	{
		$clients = Client::where('status', Client::STATUS_LIVE)->orderBy('name')->get();

		$projects = Project::searchableProperties($this->search)
		                   ->filterBy('client_id', $this->client)
		                   ->filterBy('status', $this->status)
		                   ->with('client')
		                   ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
		                   ->get();

		$statuses = Project::STATUSES;

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
