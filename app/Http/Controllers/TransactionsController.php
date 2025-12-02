<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TransactionsRepository;
use App\Http\Resources\TransactionsResource;
use App\Http\Resources\TransactionsCreditResource;

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
        $data = $request->only(['amount', 'type', 'use_amount']);
        $data['client_id'] = $id;
        try {
            $transaction = $this->transactionsRepository->create($data);
            $transactionId = $transaction->id;
            if ($data['type'] === 'credit') {
                $this->transactionsRepository->addbalance($data['client_id'], $data['amount']);
                return response()->json($transaction, 201);
            } elseif ($data['type'] === 'debit') {
                $this->transactionsRepository->createCreditTransaction($transactionId, $data['client_id'],$data['type'], $data['amount'], $data['use_amount'] ?? false);
                return response()->json($transaction, 201);
            } elseif ($data['type'] === 'payment') {
                $creditTransaction = $this->transactionsRepository->createCreditTransaction($transactionId, $data['client_id'],$data['type'], $data['amount'], $data['use_amount'] ?? false);
                $this->transactionsRepository->addpayment($creditTransaction->id, $transaction, $data['amount']);
                return response()->json(['message' => 'Payment generate.', 'data' => new TransactionsCreditResource($transaction)], 200);
            } elseif ($data['type'] === 'charge') {
                $creditTransaction = $this->transactionsRepository->createCreditTransaction($transactionId, $data['client_id'],$data['type'], $data['amount'], $data['use_amount'] ?? false);
                $this->transactionsRepository->subtractcharge($creditTransaction->id, $transaction, $data['amount']);
                return response()->json(['message' => 'Charge generate.', 'data' => new TransactionsCreditResource($transaction)], 200);
            }
            return response()->json($transaction, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function storecredit(Request $request)
    {
        $data = $request->only(['amount', 'type', 'use_amount', 'client_id']);
        $type = $data['type'];
        try {
            if ($data['type'] == 'debt') {
                $data['type'] = "debit";
                $transaction = $this->transactionsRepository->create($data);
                $transactionId = $transaction->id;
                    if ($data['use_amount'] == true) {
                        $this->transactionsRepository->subtractbalance($data['client_id'], $data['amount']);
                    }
                $this->transactionsRepository->createCreditTransaction($transactionId, $data['client_id'],$type, $data['amount'], $data['use_amount'] ?? false);
                return response()->json($transaction, 201);
            }
            else if($data['type'] == 'collection'){
                $data['type'] = "credit";
                $transaction = $this->transactionsRepository->create($data);
                $transactionId = $transaction->id;
                if ($data['use_amount'] == true) {
                    $this->transactionsRepository->addbalance($data['client_id'], $data['amount']);
                }
                $this->transactionsRepository->createCreditTransaction($transactionId, $data['client_id'],$type, $data['amount'], $data['use_amount'] ?? false);
                return response()->json($transaction, 201);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    

    public function storepay(Request $request, $id)
    {
        $data = $request->only(['amount', 'type', 'use_amount', 'client_id']);
        try {
            $creditTransaction = $this->transactionsRepository->findCreditTransaction($id);
            if (!$creditTransaction) {
                return response()->json(['error' => 'Credit transaction not found'], 404);
            }
            $amount = $data['amount'];
            $type = $data['type'];
            $transactionData = [
                'client_id' => $creditTransaction->client_id,
                'type' => $type,
                'amount' => $amount,
                'use_amount' => $data['use_amount'] ?? false
            ];
            $transaction = $this->transactionsRepository->create($transactionData);
            if ($type === 'payment') {
                $this->transactionsRepository->addpayment($creditTransaction->id, $transaction, $amount);
                return response()->json(['message' => 'Payment generate.', 'data' => new TransactionsCreditResource($transaction)], 200);
            }
            if ($type === 'charge') {
                $this->transactionsRepository->subtractcharge($creditTransaction->id, $transaction, $amount);
                return response()->json(['message' => 'Charge generate.', 'data' => new TransactionsCreditResource($transaction)], 200);
            }
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
