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
        $data = $request->only(['amount', 'type']);
        $transaction = $this->transactionsRepository->create($data);
        return response()->json($transaction, 201);
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
}
