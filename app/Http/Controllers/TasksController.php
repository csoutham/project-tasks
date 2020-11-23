<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\TaskIndexRequest;
use App\Http\Requests\Tasks\TaskCreateRequest;
use App\Http\Requests\Tasks\TaskStoreRequest;
use App\Http\Requests\Tasks\TaskShowRequest;
use App\Http\Requests\Tasks\TaskEditRequest;
use App\Http\Requests\Tasks\TaskUpdateRequest;
use App\Http\Requests\Tasks\TaskDestroyRequest;
use App\Models\Task;

class TasksController extends Controller
{
	public function index(TaskIndexRequest $request)
	{
		return view('tasks.index');
	}

	public function create(TaskCreateRequest $request)
	{
		$statuses = Task::STATUSES;
        		
        return view('tasks.create')->with([
            'statuses' => $statuses,
        ]);
	}

	public function store(TaskStoreRequest $request)
	{
		$validated = $request->validated();
        		
        Task::create($validated);

        return redirect()->action('\App\Http\Controllers\TasksController@index')->with('success', 'You have successfully created a task.');
	}

	public function show(TaskShowRequest $request, Task $task)
	{
		return view('tasks.show')->with([
		    'task' => $task
        ]);
	}

	public function edit(TaskEditRequest $request, Task $task)
	{
		$statuses = Task::STATUSES;
                		
        return view('tasks.edit')->with([
            'task' => $task,
            'statuses' => $statuses,
        ]);
	}

	public function update(TaskUpdateRequest $request, Task $task)
	{
		$validated = $request->validated();
        
        $task->update($validated);
        
        return redirect()->action('\App\Http\Controllers\TasksController@index')->with('success', 'You have successfully updated a task.');
	}

	public function destroy(TaskDestroyRequest $request, Task $task)
	{
		$task->delete();
		
		return redirect()->action('\App\Http\Controllers\TasksController@index')->with('success', 'You have successfully deleted a task.');
	}
}
