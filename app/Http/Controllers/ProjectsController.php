<?php

namespace App\Http\Controllers;

use App\Http\Requests\Projects\ProjectCreateRequest;
use App\Http\Requests\Projects\ProjectDestroyRequest;
use App\Http\Requests\Projects\ProjectEditRequest;
use App\Http\Requests\Projects\ProjectIndexRequest;
use App\Http\Requests\Projects\ProjectShowRequest;
use App\Http\Requests\Projects\ProjectStoreRequest;
use App\Http\Requests\Projects\ProjectUpdateRequest;
use App\Models\Client;
use App\Models\Project;
use App\Services\ClientService;
use App\Services\ProjectService;

class ProjectsController extends Controller
{
	protected $projectService;

	public function __construct(ProjectService $projectService)
	{
		$this->projectService = $projectService;
	}

	public function index(ProjectIndexRequest $request)
	{
		return view('projects.index');
	}

	public function create(ClientService $clientService, ProjectCreateRequest $request)
	{
		$clients = $clientService->getClients();

		$statuses = Project::STATUSES;

		return view('projects.create')->with([
			'clients' => $clients,
			'statuses' => $statuses,
		]);
	}

	public function store(ProjectStoreRequest $request)
	{
		$validated = $request->validated();

		$this->projectService->createProject(Project::create($validated));

		return redirect()->action('\App\Http\Controllers\ProjectsController@index')->with('success', 'You have successfully created a project.');
	}

	public function show(ProjectShowRequest $request, Project $project)
	{
		return view('projects.show', compact('project'));
	}

	public function edit(ProjectEditRequest $request, Project $project)
	{
		$clients = Client::orderBy('name')
		                 ->get();

		$statuses = Project::STATUSES;

		return view('projects.edit')->with([
			'clients' => $clients,
			'project' => $project,
			'statuses' => $statuses,
		]);
	}

	public function update(ProjectUpdateRequest $request, Project $project)
	{
		$validated = $request->validated();

		$project->update($validated);

		return redirect()->action('\App\Http\Controllers\ProjectsController@index')->with('success', 'You have successfully updated a project.');
	}

	public function destroy(ProjectDestroyRequest $request, Project $project)
	{
		$project->delete();

		return redirect()->action('\App\Http\Controllers\ProjectsController@index')->with('success', 'You have successfully deleted a project.');
	}
}
