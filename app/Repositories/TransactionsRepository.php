<?php

namespace App\Repositories;
use App\Models\Transactions;
use App\Models\Client;
use App\Models\CreditTransactions;

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
    public function addbalance(int $clientId, float $amount): ?Client
    {
        $user = Client::find($clientId);
        if ($user) {
            $user->balance += $amount;
            $user->save();
        }
        return $user;
    }

    public function subtractbalance(int $clientId, float $amount): ?Client
    {
        $user = Client::find($clientId);
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

    public function createCreditTransaction(int $transactionId, int $clientId, string $type, float $amount, bool $useAmount): CreditTransactions
    {
        return CreditTransactions::create([
            'transaction_id' => $transactionId,
            'client_id' => $clientId,
            'type' => $type,
            'amount' => $amount,
            'use_amount' => $useAmount,
        ]);
    }

    public function addpayment(int $transactionId, Transactions $transaction, float $amount): ?CreditTransactions
        {
            $creditTransaction = CreditTransactions::find($transactionId);
            if (!$creditTransaction || $creditTransaction->amount < $amount || $creditTransaction->amount < 0) {
                throw new \Exception('Insufficient credit transaction amount');
            }
            $client = Client::find($creditTransaction->client_id);
            if (!$client) {
                return null;
            }
            $creditTransaction->amount -= $amount;
            $creditTransaction->transaction_id = $transaction->id;
            $creditTransaction->save();
            if (filter_var($transaction->use_amount, FILTER_VALIDATE_BOOLEAN)) {
                $client->balance -= $amount;
                $client->save();
            }
            return $creditTransaction;
        }

    public function subtractcharge(int $transactionId, Transactions $transaction, float $amount): ?CreditTransactions
        {
            $creditTransaction = CreditTransactions::find($transactionId);
            if (!$creditTransaction) {
                throw new \Exception('Credit transaction not found');
            }
            $client = Client::find($creditTransaction->client_id);
            if (!$client) {
                return null;
            }
            $creditTransaction->amount += $amount;
            $creditTransaction->transaction_id = $transaction->id;
            $creditTransaction->save();
            if (filter_var($transaction->use_amount, FILTER_VALIDATE_BOOLEAN)) {
                if ($client->balance < $amount) {
                    throw new \Exception('Insufficient client balance');
                }
                $client->balance += $amount;
                $client->save();
            }
            return $creditTransaction;
        }

    public function findCreditTransaction(int $id): ?CreditTransactions
    {
        return CreditTransactions::find($id);
    }

}