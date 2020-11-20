<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Livewire\WithPagination;

class ClientsTable extends LivewireHelper
{
	use WithPagination;

	public $perPage = 30;
	public $sortField = 'name';
	public $sortAsc = true;
	public $status = Client::STATUS_LIVE;
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
		$clients = Client::searchableProperties($this->search)
		                 ->filterBy('status', $this->status)
		                 ->with('projects')
		                 ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
		                 ->get();

		$statuses = Client::STATUSES;

		$clients = $this->paginateCollection($clients, $this->perPage);

		return view('livewire.clients-table')->with([
			'clients' => $clients,
			'statuses' => $statuses,
		]);
	}

	public function paginationView()
	{
		return 'components.pagination';
	}
}
