<?php

use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UserController;
use App\Models\Archivo;
use App\Models\User;
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

    Route::get('user', function (Request $request) {
        $user = User::where('id', $request->user()->id)->with('roles')->first();

        return response()->json($user);
    });

    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('users', [UserController::class, 'update']);

    Route::get('users', [UserController::class, 'index']);
    
    Route::post('users', [UserController::class, 'store']);

    Route::get('tareas', [TareaController::class, 'index']);

    Route::post('tareas', [TareaController::class, 'store']);
    Route::delete('tareas/{id}', [TareaController::class, 'destroy']);
    Route::put('tareas/{id}', [TareaController::class, 'modifyEmployee']);
    Route::patch('tareas/{id}', [TareaController::class, 'update']);


    Route::post('comentarios', [ComentarioController::class, 'store']);

    Route::delete('archivos/{id}', [ArchivoController::class, 'destroy']);
    Route::post('archivos', [ArchivoController::class, 'store']);
});

Route::post('login', [AuthController::class, 'login']);


Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);
