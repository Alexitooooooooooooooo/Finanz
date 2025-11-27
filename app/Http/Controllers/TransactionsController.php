<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TransactionsRepository;
use App\Http\Resources\TransactionsResource;

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
        return response()->json(['message'=> 'transactions found.', 'data' => TransactionsResource::collection($transactions)]);
    }

    public function store(Request $request, $id)
    {
        $data = $request->only(['amount', 'type']);
        $data['client_id'] = $id;
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
        try {
            $transaction = $this->transactionsRepository->find($id);
            if ($transaction) {
                return response()->json($transaction);
            }
            return response()->json(['message' => 'Transaction not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
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
}
