<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $data = $request->only(['name', 'email', 'password']);
        $user = $this->userRepository->create($data);
        return response()->json($user, 201);
    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['name', 'email', 'password']);
        $user = $this->userRepository->update($id, $data);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    public function destroy($id)
    {
        $deleted = $this->userRepository->delete($id);
        if ($deleted) {
            return response()->json(['message' => 'User deleted']);
        }
        return response()->json(['message' => 'User not found'], 404);
    }
}
