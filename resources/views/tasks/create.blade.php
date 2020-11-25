<x-app-layout>
	<x-slot name="header">
		<h2 class="text-2xl text-gray-800 title">Add task</h2>
	</x-slot>
	
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <x-flash />
        
        <div class="px-4 py-4 bg-white overflow-hidden shadow-sm sm:rounded-md">
            <form action="{{ action('\App\Http\Controllers\TasksController@store') }}" method="post">
                @method('POST')
                @csrf
    
                <div class="flex flex-wrap mb-8">
                    <div class="w-64">
                        @include('components.forms.select', [
                           'label' => __('Project'),
                           'name' => 'project_id',
                           'data' => $projects->pluck('name', 'fid'),
                           'dataWithKeys' => true,
                           'value' => old('project_id'),
                           'required' => true,
                           'errors' => $errors,
                        ])
                    </div>
                </div>
                
                <div class="flex flex-wrap mb-6">
                    @include('components.forms.input', [
                       'type' => 'text',
                       'label' => __('Title'),
                       'name' => 'title',
                       'placeholder' => __('Title'),
                       'value' => old('title'),
                       'required' => true,
                       'params' => ['minlength' => 4, 'maxlength' => 160],
                       'errors' => $errors,
                    ])
                </div>
                
                <div class="flex flex-wrap mb-6">
                    @include('components.forms.textarea', [
                       'label' => __('Description'),
                       'name' => 'description',
                       'placeholder' => __('Description'),
                       'value' => old('description'),
                       'required' => true,
                       'params' => ['minlength' => 4, 'maxlength' => 160],
                       'errors' => $errors,
                    ])
                </div>
                
                <div class="flex flex-wrap mb-8">
                    <div class="w-64">
                        @include('components.forms.select', [
                           'label' => __('Status'),
                           'name' => 'status',
                           'data' => $statuses,
                           'value' => old('status', 'published'),
                           'required' => true,
                           'errors' => $errors,
                           'modifier' => 'ucfirst-values',
                        ])
                    </div>
                </div>
                
                <div class="flex flex-wrap">
                    @include('components.forms.button', [
                        'type' => 'submit',
                        'text' => __('Create task')
                    ])
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
