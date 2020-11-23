<?php

namespace App\Http\Livewire;

use App\Http\Livewire\LivewireHelper;
use App\Models\Task;
use Livewire\WithPagination;

class TasksTable extends LivewireHelper
{
	use WithPagination;

	public $perPage = 30;
	public $sortField = 'title';
	public $sortAsc = true;
	public $status = null;
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
		$tasks = Task::searchableProperties($this->search)
		                         ->filterBy('status', $this->status)
		                         ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
		                         ->get();
		                         
        $statuses = Task::STATUSES;

		$tasks = $this->paginateCollection($tasks, $this->perPage);

		return view('livewire.tasks-table')->with([
		    'tasks' => $tasks,
		    'statuses' => $statuses,
        ]);
	}

	public function paginationView()
	{
		return 'components.pagination';
	}
}
