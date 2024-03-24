<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\user;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterUserRequest $request): JsonResponse
    {

        if (!Gate::allows('create', User::class)) {
            return response()->json(['error' => 'No tiene permisos para crear usuarios'], 403);
        }

        /* generar contraseña temporal para el usuario de 8 caracteres */
        $contrasenaTemporal = Str::random(8);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($contrasenaTemporal),
        ]);
        $role = $request->input('tipo-rol') == 1 ? 'super-admin' : 'empleado';
        $user->assignRole($role);
        $user['tipo-rol'] = $role;

        /*Mandar email para informarle que se creo su cuenta pero que tiene que activarla poniendo una contras */
        Mail::send('emails.notificacion', ['data' => $user], function ($message) {
            $message->to('correo@ejemplo.com')->subject('Creacion de cuenta | now now Prueba Tecnica ');
        });

        return response()->json(['success' => 'Usuario creado correctamente'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        //
    }
}
