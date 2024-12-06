<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignIn extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Esta función actualmente no tiene implementación.
        // Podría ser utilizada para listar los usuarios o recursos relacionados.
    }

    /**
     * Función para manejar el acceso de usuarios a la aplicación.
     */
    public function signin(Request $request)
    {
        // Valida los datos enviados en el cuerpo de la solicitud (request).
        // Se asegura de que el correo electrónico sea obligatorio y tenga un formato válido,
        // así como que la contraseña sea proporcionada.
        $request->validate([
            'email' => 'required|email',  // El campo 'email' es obligatorio y debe ser un correo válido.
            'password' => 'required'     // El campo 'password' es obligatorio.
        ]);

        // Busca al usuario en la base de datos usando el correo electrónico proporcionado.
        // Devuelve el primer registro coincidente o 'null' si no existe.
        $user = User::where('email', $request->email)->first();

        // Verifica si:
        // - No se encontró un usuario con ese correo electrónico.
        // - La contraseña proporcionada no coincide con la contraseña almacenada (encriptada).
        // Si alguna de estas condiciones no se cumple, responde con un mensaje de error y un código HTTP 401 (no autorizado).
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Las credenciales son incorrectas', // Mensaje de error.
                401                                           // Código HTTP 401.
            ]);
        }

        // Si las credenciales son correctas, genera un token de autenticación para el usuario.
        // 'auth_token' es el nombre asignado al token.
        // 'plainTextToken' devuelve el token en formato de texto plano.
        $token = $user->createToken('auth_token')->plainTextToken;

        // Responde con un código HTTP 200 (éxito) y devuelve un JSON que contiene:
        // - El token de acceso generado.
        // - El tipo de token ('Bearer'), que indica el esquema de autenticación utilizado.
        return response()->json([
            'access_token' => $token,  // El token generado para el usuario.
            'token_type' => 'Bearer', // El tipo de token.
        ]);
    }
}
