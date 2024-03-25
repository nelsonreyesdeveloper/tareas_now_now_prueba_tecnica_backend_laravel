<?php

use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UserController;
use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::put('users', [UserController::class, 'update']);
    Route::post('users', [UserController::class, 'store']);

    Route::post('tareas', [TareaController::class, 'store']);
    Route::delete('tareas/{id}', [TareaController::class, 'destroy']);
    Route::put('tareas/{id}', [TareaController::class, 'modifyEmployee']);
    Route::patch('tareas/{id}', [TareaController::class, 'update']);


    Route::post('comentarios', [ComentarioController::class, 'store']);

    Route::delete('archivos/{id}', [ArchivoController::class, 'destroy']);
});

Route::post('login', [AuthController::class, 'login']);


Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
