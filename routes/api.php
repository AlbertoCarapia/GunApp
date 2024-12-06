<?php

// Importa clases necesarias para trabajar con Request, rutas y controladores en Laravel.
use Illuminate\Http\Request; // Clase para manejar solicitudes HTTP.
use Illuminate\Support\Facades\Route; // Clase para definir las rutas de la API.
use App\Http\Controllers\Api\SignIn; // Controlador para gestionar el inicio de sesión.
use App\Models\Weapon; // Modelo que representa la tabla "Weapon" en la base de datos.
use App\Models\Record; // Modelo que representa la tabla "Record" en la base de datos.
use App\Http\Controllers\Api\TotalController; // Controlador para manejar lógica de "Total".
use App\Http\Controllers\Api\TypeController; // Controlador para gestionar los "Types".

// Define una ruta POST para crear tipos. El controlador `createTypes` maneja la lógica.
// La ruta utiliza el middleware 'auth:sanctum' para asegurar que solo usuarios autenticados puedan acceder.
Route::post('/create-types', [TypeController::class, 'createTypes'])->middleware('auth:sanctum');

// Define una ruta POST para el inicio de sesión. El método 'signin' en el controlador `SignIn` gestiona la solicitud.
// Se asigna un nombre 'signin' a la ruta para facilitar su referencia.
Route::post('signin', [SignIn::class, 'signin'])->name('signin');

// Define una ruta DELETE para eliminar un registro por su ID.
// Busca el registro en la base de datos utilizando el modelo `Record`.
// Si el registro existe, lo elimina y devuelve una respuesta JSON con un mensaje de éxito.
// Si no se encuentra el registro, devuelve un mensaje de error con código HTTP 404.
// La ruta está protegida por el middleware 'auth:sanctum'.
Route::delete('/RDelete/{id}', function ($id) {
    $record = Record::find($id); // Busca el registro por su ID.

    if ($record) {
        $record->delete(); // Elimina el registro si existe.
        return response()->json(['message' => 'Registro eliminado correctamente']);
    } else {
        return response()->json(['message' => 'Registro no encontrado'], 404); // Respuesta en caso de error.
    }
})->middleware('auth:sanctum');

// Define una ruta GET para obtener información total (detalles manejados por el controlador `TotalController`).
// El método `Total` contiene la lógica para procesar la solicitud.
// La ruta está protegida con el middleware 'auth:sanctum' para usuarios autenticados.
Route::get('Total', [TotalController::class, 'Total'])->name('Total')->middleware('auth:sanctum');

// Define una ruta GET para obtener armas según su disponibilidad (por estado).
// Usa el modelo `Weapon` para filtrar las armas con base en el estado (`in_stock`).
// Devuelve los resultados como una respuesta JSON.
// Protegida por el middleware 'auth:sanctum'.
Route::get('weapons/availability/{status}', function ($status) {
    $weapons = Weapon::where('in_stock', $status)->get(); // Filtra armas según disponibilidad.
    return response()->json($weapons); // Devuelve los datos en formato JSON.
})->middleware('auth:sanctum');
