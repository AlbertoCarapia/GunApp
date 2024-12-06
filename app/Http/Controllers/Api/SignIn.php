<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignIn extends Controller
{
    /**
     * Función para mostrar una lista de recursos (no implementada actualmente).
     */
    public function index()
    {
        // Esta función podría usarse en el futuro para listar usuarios o recursos relacionados.
    }

    /**
     * Maneja el inicio de sesión de los usuarios en la aplicación.
     */
    public function signin(Request $request)
    {
        // Realiza la validación de los datos recibidos en la solicitud.
        // Verifica que se proporcione un correo electrónico válido y una contraseña.
        $request->validate([
            'email' => 'required|email',  // Campo obligatorio y debe ser un correo válido.
            'password' => 'required'     // Campo obligatorio para la contraseña.
        ]);

        // Busca un usuario en la base de datos que coincida con el correo electrónico proporcionado.
        $user = User::where('email', $request->email)->first();

        // Verifica si el usuario existe y si la contraseña proporcionada coincide con la almacenada (encriptada).
        // Si no, responde con un error de autenticación (código HTTP 401).
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Las credenciales son incorrectas', // Mensaje de error en caso de fallo.
            ], 401); // Código de estado para "No autorizado".
        }

        // Genera un token de acceso para el usuario autenticado.
        // El token será utilizado para futuras solicitudes autenticadas.
        $token = $user->createToken('auth_token')->plainTextToken;

        // Responde con un código de éxito (200) y devuelve un JSON que incluye:
        // - El token generado para el usuario.
        // - El tipo de token ('Bearer'), que se usa en el esquema de autenticación.
        return response()->json([
            'access_token' => $token,  // Token generado para el usuario.
            'token_type' => 'Bearer', // Indica el esquema de autenticación utilizado.
        ]);
    }
}
