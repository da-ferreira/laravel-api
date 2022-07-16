<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->all(['email', 'password']);

        // Realiza uma tentativa de autenticação.
        // Se ela for realizada com sucesso, o método retorna um token; caso contrário, retorna false
        $token = auth('api')->attempt($credentials);

        if ($token) {
            return response()->json(['token' => $token], 200);
        }

        // 401 = Unauthorized -> Não autorizado
        // 403 = Forbidden -> Proibido
        return response()->json(['message' => 'Invalid username or password'], 403);
    }

    public function logout()
    {
        return 'Logout';
    }

    public function refresh()
    {
        return 'Refresh';
    }

    public function me()
    {
        return 'Me';
    }
}
