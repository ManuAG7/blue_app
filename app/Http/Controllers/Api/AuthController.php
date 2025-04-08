<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Registro de usuario
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('YourAppName')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    // Login de usuario
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('YourAppName')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    // Verificación de código (puede ser por email o teléfono)
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|integer',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->verification_code != $request->code) {
            return response()->json(['message' => 'Invalid verification code'], 400);
        }

        $user->update(['email_verified_at' => now()]);

        return response()->json(['message' => 'Email verified successfully']);
    }
}
