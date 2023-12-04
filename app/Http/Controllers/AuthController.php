<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function Sentry\captureMessage;

class AuthController extends Controller
{
    public function index(): JsonResponse
    {
        $data = User::all();
        return response()->json(['status' => true, 'data' => $data], 201);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        /*if ($user->id !== auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }*/

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function register(Request $request): JsonResponse
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
        ]);

        // Create a new user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => $validatedData['role'],
        ]);

        // Optionally, you can authenticate the user here after signup if needed

        return response()->json(['message' => 'User registered successfully']);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Retrieve the authenticated user
            $token = $user->createToken('AuthToken')->plainTextToken;

            return response()->json(['userId' => $user->getAuthIdentifier(), 'token' => $token]);
        } else {
            captureMessage('Invalid credentials logging in');
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

}
