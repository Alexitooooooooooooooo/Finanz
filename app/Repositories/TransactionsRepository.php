<?php

namespace App\Repositories;
use App\Models\Transactions;

class TransactionsRepository
{

    protected $model;

    public function __construct()
    {
        $this->model = new Transactions();
    }

    public function all()
    {
        return $this->model->all();
    }

    public function create(array $data): Transactions
    {
        return $this->model->create($data);
    }

    public function find(int $id): ?Transactions
    {
        return $this->model->find($id);
    }

    public function update(int $id, array $data): ?Transactions
    {
        $transaction = $this->find($id);
        if ($transaction) {
            $transaction->update($data);
        }
        return $transaction;
    }

    public function delete(int $id): bool
    {
        $transaction = $this->find($id);
        if ($transaction) {
            return $transaction->delete();
        }
        return false;
    }
}