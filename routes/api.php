<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

// Ruta de prueba de usuario autenticado (requiere autenticación)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas relacionadas con los usuarios (CRUD)
Route::get('/users', [UserController::class, 'index']);  // Listar todos los usuarios
Route::get('/user/{user}', [UserController::class, 'show']); // Obtener un usuario por ID
Route::post('/register', [UserController::class, 'store']); // Crear un nuevo usuario
Route::put('/user/{id}', [UserController::class, 'update']); // Actualizar un usuario
Route::delete('/user/{id}', [UserController::class, 'destroy']); // Eliminar un usuario

// Rutas para autenticación de usuarios
Route::post('/login', [AuthController::class, 'login']);   // Iniciar sesión
Route::post('/register', [AuthController::class, 'register']); // Registro de usuarios
Route::post('/verify', [AuthController::class, 'verifyCode']); // Verificación de código (para email o teléfono)

