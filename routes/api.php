<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\TransactionsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::get('/clients', [ClientsController::class, 'index']);
Route::post('/clients', [ClientsController::class, 'store']);
Route::get('/clients/{id}', [ClientsController::class, 'show']);
Route::put('/clients/{id}', [ClientsController::class, 'update']);
Route::delete('/clients/{id}', [ClientsController::class, 'destroy']);

Route::get('/client/{clientId}/transactions', [ClientsController::class, 'showTransactions']);


Route::post('/transactions/{id}', [TransactionsController::class, 'store']);
Route::get('/transactions', [TransactionsController::class, 'index']);
Route::get('/transactions/{id}', [TransactionsController::class, 'show']);
Route::put('/transactions/{id}', [TransactionsController::class, 'update']);
Route::delete('/transactions/{id}', [TransactionsController::class, 'destroy']);

