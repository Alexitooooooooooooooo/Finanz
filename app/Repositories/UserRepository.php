<?php

namespace App\Repositories;
use App\Models\User;

class UserRepository
{

    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function find(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data): ?User
    {
        $user = $this->find($id);
        if ($user) {
            $user->update($data);
        }
        return $user;
    }

    public function delete(int $id): bool
    {
        $user = $this->find($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }
}