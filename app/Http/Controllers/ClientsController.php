<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\ClientIndexRequest;
use App\Http\Requests\Clients\ClientCreateRequest;
use App\Http\Requests\Clients\ClientStoreRequest;
use App\Http\Requests\Clients\ClientShowRequest;
use App\Http\Requests\Clients\ClientEditRequest;
use App\Http\Requests\Clients\ClientUpdateRequest;
use App\Http\Requests\Clients\ClientDestroyRequest;
use App\Models\Client;

class ClientsController extends Controller
{
	public function index(ClientIndexRequest $request)
	{
		return view('clients.index');
	}

	public function create(ClientCreateRequest $request)
	{
		$statuses = Client::STATUSES;
        		
        return view('clients.create', compact('statuses'));
	}

	public function store(ClientStoreRequest $request)
	{
		$validated = $request->validated();
        		
        Client::create($validated);

        return redirect()->action('\App\Http\Controllers\ClientsController@index')->with('success', 'You have successfully created a client.');
	}

	public function show(ClientShowRequest $request, Client $client)
	{
		return view('clients.show', compact('client'));
	}

	public function edit(ClientEditRequest $request, Client $client)
	{
		$statuses = Client::STATUSES;
                		
        return view('clients.edit', compact('client', 'statuses'));
	}

	public function update(ClientUpdateRequest $request, Client $client)
	{
		$validated = $request->validated();
        
        $client->update($validated);
        
        return redirect()->action('\App\Http\Controllers\ClientsController@index')->with('success', 'You have successfully updated a client.');
	}

	public function destroy(ClientDestroyRequest $request, Client $client)
	{
		$client->delete();
		
		return redirect()->action('\App\Http\Controllers\ClientsController@index')->with('success', 'You have successfully deleted a client.');
	}
}
