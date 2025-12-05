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
            $user = $request->user();
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,

                ]
            ], 200);    }

    public function login(AuthRequest $request): JsonResponse
    {

        try {
            $credentials = $request->validated();
            $authData = $this->authRepository->login($credentials);

            return response()->json([
                'success' => true,
                'message' => 'Successful login',
                    'user' => $authData['user'],
                    'token' => $authData['token']
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Authentication error',
                'errors' => $e->errors()
            ], 402);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        $this->authRepository->logout($user);
        return response()->json(['message' => 'User logged out successfully.'], 200);
    }



}