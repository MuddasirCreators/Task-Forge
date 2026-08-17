<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

class ClientController extends Controller
{
    /**
     * Display all clients.
     */
    public function index()
    {
        $clients = Client::latest()->paginate(10);

        return view('clients.index', compact('clients'));
    }

    /**
     * Show the create client form.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created client.
     */
    public function store(StoreClientRequest $request)
    {
        Client::create(array_merge(

            $request->validated(),

            [
                'created_by' => auth()->id(),
            ]

        ));

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    /**
     * Show the edit client form.
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified client.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update(

            $request->validated()

        );

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    /**
     * Delete the specified client.
     */
    public function destroy(Client $client)
    {
        /*
        |--------------------------------------------------------------------------
        | Client cannot be deleted if any project is Pending or In Progress
        |--------------------------------------------------------------------------
        */

        if (
            $client->projects()
                ->whereIn('status', [
                    'Pending',
                    'In Progress'
                ])
                ->exists()
        ) {

            return redirect()
                ->route('clients.index')
                ->with(
                    'error',
                    'Client cannot be deleted because it has Pending or In Progress projects.'
                );

        }

        /*
        |--------------------------------------------------------------------------
        | Delete Client
        |--------------------------------------------------------------------------
        */

        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with(
                'success',
                'Client deleted successfully.'
            );
    }
}