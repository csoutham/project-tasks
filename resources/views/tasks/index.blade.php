<x-app-layout>
    <x-slot name="header">
		<div class="flex flex-row justify-between">
			<h2 class="text-2xl text-gray-800 title">
				Tasks
			</h2>
				
			<a href="{{ action('\App\Http\Controllers\TasksController@create') }}" class="button button-secondary px-4 py-1">
				Add task
			</a>
		</div>
	</x-slot>
	
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <x-flash />
        
        <div class="px-4 pt-4 bg-white overflow-hidden shadow-sm sm:rounded-md">
            @livewire('tasks-table')
        </div>
	</div>
</x-app-layout>
