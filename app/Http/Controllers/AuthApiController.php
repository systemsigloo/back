<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthApiController extends Controller
{
    public function login(Request $request)
    {    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Credenciales inválidas'
        ], 401);
    }

    $token = $user->createToken('TokenPersonal')->accessToken;

    return response()->json([
        'user' => $user,
        'token' => $token,
    ]);
    }
}
