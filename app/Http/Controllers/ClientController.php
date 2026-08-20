<?php

namespace App\Http\Controllers;

use App\Actions\Clients\CreateClient;
use App\Actions\Clients\DeleteClient;
use App\Actions\Clients\UpdateClient;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

use App\Models\Client;

use Illuminate\Support\Facades\Gate;

class ClientController extends Controller
{
    /**
     * Display all clients.
     */
    public function index()
    {
        Gate::authorize(
            'viewAny',
            Client::class
        );

        $clients = Client::query()
            ->when(
                auth()->user()->role === 'Manager',
                function ($query) {
                    $query->where(
                        'created_by',
                        auth()->id()
                    );
                }
            )
            ->latest()
            ->paginate(10);

        return view(
            'clients.index',
            compact('clients')
        );
    }


    /**
     * Show the create client form.
     */
    public function create()
    {
        Gate::authorize(
            'create',
            Client::class
        );

        return view(
            'clients.create'
        );
    }


    /**
     * Store a newly created client.
     */
    public function store(
        StoreClientRequest $request,
        CreateClient $createClient
    ) {
        Gate::authorize(
            'create',
            Client::class
        );

        $createClient->execute(
            $request->validated(),
            auth()->id()
        );

        return redirect()
            ->route(
                'clients.index'
            )
            ->with(
                'success',
                'Client created successfully.'
            );
    }


    /**
     * Display the specified client.
     */
    public function show(
        Client $client
    ) {
        Gate::authorize(
            'view',
            $client
        );

        return view(
            'clients.show',
            compact('client')
        );
    }


    /**
     * Show the edit client form.
     */
    public function edit(
        Client $client
    ) {
        Gate::authorize(
            'update',
            $client
        );

        return view(
            'clients.edit',
            compact('client')
        );
    }


    /**
     * Update the specified client.
     */
    public function update(
        UpdateClientRequest $request,
        Client $client,
        UpdateClient $updateClient
    ) {
        Gate::authorize(
            'update',
            $client
        );

        $updateClient->execute(
            $client,
            $request->validated()
        );

        return redirect()
            ->route(
                'clients.index'
            )
            ->with(
                'success',
                'Client updated successfully.'
            );
    }


    /**
     * Delete the specified client.
     */
    public function destroy(
        Client $client,
        DeleteClient $deleteClient
    ) {
        Gate::authorize(
            'delete',
            $client
        );

        $deleted = $deleteClient->execute(
            $client
        );

        if (!$deleted) {
            return redirect()
                ->route(
                    'clients.index'
                )
                ->with(
                    'error',
                    'Client cannot be deleted because it has Pending or In Progress projects.'
                );
        }

        return redirect()
            ->route(
                'clients.index'
            )
            ->with(
                'success',
                'Client deleted successfully.'
            );
    }
}