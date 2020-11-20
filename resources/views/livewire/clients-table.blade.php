<div class="pb-4">
	<div class="flex flex-row pb-6">
		<div class="w-1/2 pb-2 pr-2 xl:pr-4 xl:pb-0 lg:w-1/4">
			@include('components.forms.input', [
			   'type' => 'text',
			   'label' => __('Keywords'),
			   'name' => 'search',
			   'placeholder' => __('Search'),
			   'params' => [
				   'wire:model' => 'search'
			   ]
			])
		</div>
		<div class="w-1/2 pb-2 pr-2 xl:pr-4 xl:pb-0 lg:w-1/5">
			@include('components.forms.select', [
			   'label' => __('Status'),
				'name' => 'status',
				'data' => $statuses,
				'nullValue' => 'Any',
				'value' => null,
				'params' => [
				   'wire:model' => 'status'
				],
				'modifier' => 'ucfirst-values',
			])
		</div>
		
		<div class="w-full self-center hidden lg:block">
			<p class="mt-5 text-sm text-right lg:text-sm">
				Showing @if ($clients->total() != 0)
					{{ $clients->firstItem() }} to {{ $clients->lastItem() }} of
				@endif
				{{ $clients->total() }} results
			</p>
		</div>
	</div>
	
	@if ($clients->total() === 0)
		<div class="flex h-32 px-6 py-6 bg-white border border-gray-200 justify-center items-center rounded-lg">
            <h3 class="text-sm text-gray-600">No results found, please try different filters.</h3>
        </div>
	
	@else
		<div class="flex flex-col">
            <div class="pb-12 overflow-x-auto">
                <table class="min-w-full table-fixed">
                    <thead class="text-left border-b border-gray-200 bg-gray-100">
                        <tr>
                            <th class="pl-4 column-header">
                                Name
                            </th>
	                        <th class="column-header" style="width: 160px;">
		                        Projects
	                        </th>
	                        <th class="column-header" style="width: 160px;">
		                        Status
	                        </th>
	                        <th class="column-header" style="width: 160px;">
		                        Created At
	                        </th>
	                        <th style="width: 60px;"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-gray-100">
                        @foreach ($clients as $client)
                            <tr class="hover:bg-gray-50">
                                <td class="pl-4 column-body">
                                    <a href="{{ action('\App\Http\Controllers\ClientsController@edit', $client) }}" class="text-blue-600 font-semibold">
                                        {{ $client->name }}
                                    </a>
                                </td>
	                            <td class="column-body">
		                            {{ $client->projects->count() }}
	                            </td>
                                <td class="column-body">
                                    <span
                                        class="inline-flex px-4 py-2 text-xs font-semibold text-gray-600 bg-gray-100 rounded-full">{{ ucfirst($client->status) }}</span>
                                </td>
                                <td class="column-body">
                                    {{ $client->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="column-body text-right pr-4">
                                    <form action="{{ action('\App\Http\Controllers\ClientsController@destroy', $client) }}"
                                          method="post">
                                        @csrf
                                        @method('DELETE')
                                        
                                        <button type="submit">
                                            <x-heroicon-o-trash class="w-6 h-6 text-red-600 hover:text-black"/>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
	@endif
	
    {{ $clients->links() }}
</div>
