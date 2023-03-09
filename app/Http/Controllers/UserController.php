<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        $datos_formulario = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if (auth()->attempt($datos_formulario)) {
            $request->session()->regenerate();
            $response = [
                'success' => true,
                'message' => 'Usuario identificado',
            ];
            return response()->json($response, 200);
        }

        $response = [
            'success' => false,
            'message' => 'Correo o contraseña incorrectos',
        ];
        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $response = [
            'success' => true,
        ];
        return response()->json($response, 200);
    }
}
