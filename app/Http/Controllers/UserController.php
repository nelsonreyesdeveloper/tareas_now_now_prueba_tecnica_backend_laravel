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

use Spatie\Permission\Models\Role;

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

        $usuario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($contrasenaTemporal),
        ]);


        $rol = $request->input('tipo-rol') == 1 ? 'super-admin' : 'empleado';

        $roleBD = Role::where('name', $rol)->first();

        // Valide el rol antes de asignarlo
        $usuario->assignRole($roleBD);

        $usuario['tipo-rol'] = $rol;
        $usuario['contrasena-temporal'] = $contrasenaTemporal;

        /*Mandar email para informarle que se creo su cuenta pero que tiene que activarla poniendo una contras */
        Mail::send('emails.notificacion', ['data' => $usuario], function ($message) {
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
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password-temporal' => ['required'],

        ]);

        $user = auth()->user();
        if (!Hash::check($request->password_temporal, $user->password)) {
            return response()->json(['error' => 'La contraseña temporal es incorrecta'], 403);
        }
        /* Actualizar usuario */
        if (!Gate::allows('update', [User::class, $user])) {
            return response()->json(['error' => 'La constraseña solo se puede editar una vez'], 403);
        }
        $user->password = Hash::make($request->password);
        $user->defaultPassword = 0;
        $user->save();

        return response()->json(['success' => 'Contraseña actualizada correctamente'], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        //
    }
}
