<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; // Clase base para controladores en Laravel.
use App\Models\WeaponType; // Modelo que representa los tipos de armas.
use App\Models\LType; // Modelo que representa los tipos de licencias.
use Illuminate\Http\Request; // Clase para manejar solicitudes HTTP.

class TypeController extends Controller
{
    /**
     * Crear tanto un tipo de arma (WeaponType) como un tipo de licencia (LType) con el mismo nombre.
     */
    public function createTypes(Request $request)
    {
        // Validar los datos enviados en la solicitud.
        // Se asegura de que el campo 'name' sea obligatorio, de tipo string y no exceda 255 caracteres.
        $request->validate([
            'name' => 'required|string|max:255', // Campo 'name' validado.
        ]);

        // Crear un nuevo registro en la tabla `weapon_types` con el nombre proporcionado.
        $weaponType = WeaponType::create([
            'name' => $request->name, // Se asigna el nombre recibido en la solicitud.
        ]);

        // Crear un nuevo registro en la tabla `l_types` con el mismo nombre.
        $lType = LType::create([
            'name' => $request->name, // Se utiliza el mismo nombre para ambos tipos.
        ]);

        // Retornar una respuesta JSON que incluye ambos objetos creados.
        // La respuesta tiene un código HTTP 201, que indica que los recursos fueron creados correctamente.
        return response()->json([
            'weapon_type' => $weaponType, // Objeto creado en la tabla `weapon_types`.
            'l_type' => $lType,          // Objeto creado en la tabla `l_types`.
        ], 201); // Código HTTP 201 para indicar creación exitosa.
    }
}
