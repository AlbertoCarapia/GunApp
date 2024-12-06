<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\WeaponType;
use App\Models\LType;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    // Crear tanto un WeaponType como un LType con el mismo nombre
    public function createTypes(Request $request)
    {
        // Validar el nombre
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Crear el WeaponType
        $weaponType = WeaponType::create([
            'name' => $request->name,
        ]);

        // Crear el LType
        $lType = LType::create([
            'name' => $request->name,
        ]);

        // Retornar ambos objetos creados en una sola respuesta
        return response()->json([
            'weapon_type' => $weaponType,
            'l_type' => $lType,
        ], 201);
    }
}
