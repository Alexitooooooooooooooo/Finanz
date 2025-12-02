<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ClientsRepository;
use App\Http\Resources\ClientsResource;
use App\Http\Request\Client\ClientCreateRequest;
use App\Http\Request\Client\ClientUpdateRequest;
use GuzzleHttp\Client;

class ClientsController extends Controller
{
    protected $clientsRepository;

    public function __construct(ClientsRepository $clientsRepository)
    {
        $this->clientsRepository = $clientsRepository;
    }
    public function index()
    {
        $clients = $this->clientsRepository->all();
        return response()->json(['message'=> 'clients found.', 'data' => ClientsResource::collection($clients)]);
    }

    public function showTransactions($clientId)
    {
        $transactions = $this->clientsRepository->allTransactionswhere($clientId);
        if ($transactions) {
            return response()->json(['message' => 'Transactions found.', 'data' => $transactions]);
        }
        return response()->json(['message' => 'Client not found or no transactions available'], 404);
    }

    public function store(ClientCreateRequest $request)
    {
        $data = $request->only(['user_id', 'name', 'email']);
        $client = $this->clientsRepository->create($data);
        return response()->json(['message' => 'Client created.', 'data' => new ClientsResource($client)], 201);
    }

    public function show($id)
    {
        $client = $this->clientsRepository->find($id);
        if ($client) {
            return response()->json(['message' => 'Client found.', 'data' => new ClientsResource($client)]);
        }
        return response()->json(['message' => 'Client not found'], 404);
    }

    public function update(ClientUpdateRequest $request, $id)
    {
        $data = $request->only(['user_id', 'name', 'email', 'balance']);
        $client = $this->clientsRepository->update($id, $data);
        if ($client) {
            return response()->json($client);
        }
        return response()->json(['message' => 'Client not found'], 404);
    }

    public function destroy($id)
    {
        $deleted = $this->clientsRepository->delete($id);
        if ($deleted) {
            return response()->json(['message' => 'Client deleted']);
        }
        return response()->json(['message' => 'Client not found'], 404);
    }
    
}
