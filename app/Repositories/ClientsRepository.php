<?php

namespace App\Repositories;
use App\Models\Clients;

class ClientsRepository
{

    protected $model;

    public function __construct()
    {
        $this->model = new Clients();
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data): Clients
    {
        return $this->model->create($data);
    }

    public function find(int $id): ?Clients
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data): ?Clients
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
}