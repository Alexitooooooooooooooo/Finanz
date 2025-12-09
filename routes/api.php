<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

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
Route::post('/transactions/pay/{id}', [TransactionsController::class, 'storepay']);


Route::post('/transactionscredit', [TransactionsController::class, 'storecredit']);



Route::get('/contacts', [ContactController::class, 'index']);
Route::post('/contacts', [ContactController::class, 'store']);
Route::get('/contacts/{id}', [ContactController::class, 'show']);
Route::put('/contacts/{id}', [ContactController::class, 'update']);
Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);
