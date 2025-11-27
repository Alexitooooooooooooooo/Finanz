<?php

namespace App\Repositories;
use App\Models\Transactions;
use App\Models\Clients;

class TransactionsRepository
{

    protected $model;

    public function __construct()
    {
        $this->model = new Transactions();
    }

    public function all()
    {
        return $this->model->with('client')->get();
    }

    public function create(array $data): Transactions
    {
        return $this->model->create($data);
    }

    public function find(int $id): ?Transactions
    {
        return $this->model->with('client')->find($id);
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
    public function addbalance(int $clientId, float $amount): ?Clients
    {
        $user = Clients::find($clientId);
        if ($user) {
            $user->balance += $amount;
            $user->save();
        }
        return $user;
    }

    public function subtractbalance(int $clientId, float $amount): ?Clients
    {
        $user = Clients::find($clientId);
        if ($user) {
            if ($user->balance >= $amount) {
                $user->balance -= $amount;
                $user->save();
            } else {
                throw new \Exception('Insufficient balance');
            }
        }
        return $user;
    }


}