<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SignIn;
use App\Models\Weapon;
use App\Models\Record;
use App\Http\Controllers\Api\TotalController;
use App\Http\Controllers\Api\TypeController;



Route::post('/create-types', [TypeController::class, 'createTypes'])->middleware('auth:sanctum');


Route::post('signin',[SignIn::class,'signin'])->name('signin');


Route::delete('/RDelete/{id}', function ($id) {
    $record = Record::find($id);

    if ($record) {
        $record->delete();
        return response()->json(['message' => 'Registro eliminada correctamente']);
    } else {
        return response()->json(['message' => 'Registro no encontrada'], 404);
    }
})->middleware('auth:sanctum');



Route::get('Total',[TotalController::class,'Total'])->name('Total')->middleware('auth:sanctum');


Route::get('weapons/availability/{status}', function ($status) {
    $weapons = Weapon::where('in_stock', $status)->get();
    return response()->json($weapons);
})->middleware('auth:sanctum');



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
