<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Services\ClientService;
use Livewire\WithPagination;

class ClientsTable extends LivewireHelper
{
	use WithPagination;

	public $perPage = 30;
	public $sortField = 'name';
	public $sortAsc = true;
	public $status = Client::STATUS_LIVE;

	protected $queryString = ['status'];

	protected $clientService;

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

	public function render(ClientService $clientService)
	{
		$statuses = Client::STATUSES;

		$clients = $clientService->getClients();

		$clients = $clientService->filterBy($clients, 'status', $this->status);
		$clients = ($this->sortAsc) ? $clients->sortBy($this->sortField) : $clients->sortByDesc($this->sortField);

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
