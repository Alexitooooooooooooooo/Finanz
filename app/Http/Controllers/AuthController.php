<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AuthRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use App\Http\Request\Auth\AuthRequest;

class AuthController extends Controller{

        public function __construct(
        private AuthRepository $authRepository
    ) {}

    public function me(Request $request): JsonResponse
    {
        return response()->json(['message' => 'User authenticated.', 'data' => $request->user()], 200);
    }

    public function login(AuthRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        try {
        $authdata = $this->authRepository->login($credentials);
            return response()->json(['message' => 'User logged in successfully.', 'data' => $authdata], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        $this->authRepository->logout($user);
        return response()->json(['message' => 'User logged out successfully.'], 200);
    }



}