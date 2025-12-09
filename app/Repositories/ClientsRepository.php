<?php

namespace App\Repositories;
use App\Models\Client;

class ClientsRepository
{

    protected $model;

    public function __construct()
    {
        $this->model = new Client();
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data): Client
    {
        return $this->model->create($data);
    }

    public function find(int $id): ?Client
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data): ?Client
    {
        $client = $this->find($id);
        if ($client) {
            $client->update($data);
        }
        return $client;
    }

    public function delete(int $id): bool
    {
        $client = $this->find($id);
        if ($client) {
            return $client->delete();
        }
        return false;
    }

    public function allTransactionswhere(int $clientId)
    {
        $client = $this->find($clientId);
        if ($client) {
            return $client->transactions;
        }
        return null;
    }
}