<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ClientsRepository;

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
        return response()->json($clients);
    }

    public function store(Request $request)
    {
        $data = $request->only(['user_id', 'name', 'email']);
        $client = $this->clientsRepository->create($data);
        return response()->json($client, 201);
    }

    public function show($id)
    {
        $client = $this->clientsRepository->find($id);
        if ($client) {
            return response()->json($client);
        }
        return response()->json(['message' => 'Client not found'], 404);
    }

    public function update(Request $request, $id)
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
