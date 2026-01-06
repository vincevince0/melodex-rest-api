<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->input('email'))->first();

    if (!$user || !Hash::check($request->input('password'), $user->password)) {
        return response()->json([
            'message' => 'Invalid email or password',
        ], 401);
    }

    // Revoke old tokens
    $user->tokens()->delete();

    // Create new token
    $token = $user->createToken('access')->plainTextToken;

    return response()->json([
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ],
        'token' => $token,
    ]);
}

    public function index(Request $request)
    {
        $users = User::all();
        return response()->json([
            'users' => $users,
        ]);
    }
}
