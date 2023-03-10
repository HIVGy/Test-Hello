<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Verifica la información del usuario y lo autentifica
     * si su información es correcta
     */
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

    /**
     * Cierra la sesión actual y tambien invalida la sesión
     * actual para volver a generarla una vez el usuario
     * inicie sesión nuevamente
     */
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
