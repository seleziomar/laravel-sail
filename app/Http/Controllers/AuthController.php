<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function logar(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|string'
        ]);

        if(!Auth::attempt($request->only(['email', 'password']))){

            return response()->json([
                'errors' => [
                    'unauthorized' => ["Email/Password does't match"]
                ]
            ], 422);

        }

        return response()->json([
            'status' => 1,
            'data' => 'ok'
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
