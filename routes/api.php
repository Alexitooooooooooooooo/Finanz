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

Route::post('/clients', [ClientsController::class, 'store']);
Route::get('/clients', [ClientsController::class, 'index']);

Route::post('/transactions', [TransactionsController::class, 'store']);