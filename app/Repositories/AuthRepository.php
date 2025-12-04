<?php

namespace App\Repositories;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthRepository
{
    public function __construct(
        private User $user
    ) {}

    /**
     * Login de usuario
     */
    public function login(array $credentials): array
{
    // Buscar usuario solo por email
    $user = $this->user->where('email', $credentials['email'])->first();

    // Verificar si el usuario existe y la contraseña es correcta
    if (!$user || !Hash::check($credentials['password'], $user->password)) {
        throw ValidationException::withMessages([
            'credentials' => ['CREDENTIALS_ERROR'],
        ]);
    }


    // Crear token Sanctum
    $token = $user->createToken('auth-token')->plainTextToken;

    return [
        'user' => $user,
        'token' => $token
    ];
}

    /**
     * Logout de usuario
     */
    public function logout(User $user): bool
    {
        // Eliminar todos los tokens del usuario
        $user->tokens()->delete();
        
        return true;
    }
}