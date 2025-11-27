<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TransactionsRepository;

class TransactionsController extends Controller
{
    protected $transactionsRepository;

    public function __construct(TransactionsRepository $transactionsRepository)
    {
        $this->transactionsRepository = $transactionsRepository;
    }

    public function index()
    {
        $transactions = $this->transactionsRepository->all();
        return response()->json($transactions);
    }

public function store(Request $request)
{
    $data = $request->only(['amount', 'type', 'client_id']);
    try {
        if ($data['type'] === 'credit') {
            $this->transactionsRepository->addbalance($data['client_id'], $data['amount']);
        } elseif ($data['type'] === 'debit') {
            $this->transactionsRepository->subtractbalance($data['client_id'], $data['amount']);
        }
        $transaction = $this->transactionsRepository->create($data);
        return response()->json($transaction, 201);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
}

    public function show($id)
    {
        $transaction = $this->transactionsRepository->find($id);
        if ($transaction) {
            return response()->json($transaction);
        }
        return response()->json(['message' => 'Transaction not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['amount', 'type']);
        $transaction = $this->transactionsRepository->update($id, $data);
        if ($transaction) {
            return response()->json($transaction);
        }
        return response()->json(['message' => 'Transaction not found'], 404);
    }

    public function destroy($id)
    {
        $deleted = $this->transactionsRepository->delete($id);
        if ($deleted) {
            return response()->json(['message' => 'Transaction deleted']);
        }
        return response()->json(['message' => 'Transaction not found'], 404);
    }

    public function addBalance(Request $request, $userId)
    {
        $amount = $request->input('amount');
        $user = $this->transactionsRepository->addbalance($userId, $amount);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    public function subtractBalance(Request $request, $userId)
    {
        $amount = $request->input('amount');
        $user = $this->transactionsRepository->subtractbalance($userId, $amount);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }
}
