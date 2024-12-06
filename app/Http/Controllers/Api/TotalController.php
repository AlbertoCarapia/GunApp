<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; // Clase base para controladores en Laravel.
use Illuminate\Http\Request; // Clase para manejar solicitudes HTTP.
use App\Models\LType; // Modelo que representa los tipos de licencia.
use App\Models\Magazine; // Modelo que representa los registros de cargadores.
use App\Models\Officer; // Modelo que representa a los oficiales.
use App\Models\Record; // Modelo que representa registros generales.
use App\Models\Weapon; // Modelo que representa las armas.
use App\Models\WeaponType; // Modelo que representa los tipos de armas.

class TotalController extends Controller
{
    /**
     * Función para obtener el total de registros de varias tablas relacionadas.
     */
    public function Total()
    {
        // Crea un arreglo que almacena el conteo total de registros en varias tablas.
        // Cada modelo realiza una consulta para contar la cantidad de registros en su tabla correspondiente.
        $total = [
            'license_types' => LType::count(), // Total de tipos de licencia.
            'magazines' => Magazine::count(), // Total de cargadores.
            'officers' => Officer::count(),   // Total de oficiales.
            'records' => Record::count(),    // Total de registros generales.
            'weapons' => Weapon::count(),    // Total de armas.
            'weapon_types' => WeaponType::count(), // Total de tipos de armas.
        ];

        // Devuelve una respuesta en formato JSON con:
        // - Un estado ('success') para indicar que la operación fue exitosa.
        // - Los datos de conteo organizados en el arreglo `$total`.
        // - Un código de estado HTTP 200 que indica éxito.
        return response()->json([
            'status' => 'success', // Estado de la respuesta.
            'data' => $total,      // Datos recopilados del conteo total.
        ], 200); // Código HTTP para respuesta exitosa.
    }
}
