<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
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
     * Store a newly created resource in storage.
     */

    public function index(Request $request)
    {
        $users = User::when($request->has('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        })->with('roles')->paginate(10);

        return response()->json($users);
    }
    public function store(RegisterUserRequest $request): JsonResponse
    {

        if (!Gate::allows('create', User::class)) {
            return response()->json(['success' => false, 'error' => 'No tiene permisos para crear usuarios','user' => auth()->user()->hasRole('super-admin')], 403);
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
        Mail::send('emails.notificacion', ['data' => $usuario], function ($message) use ($request) {
            $message->from('nelsonreyesyt@gmail.com','Nelson Reyes')->to($request->email)->subject('Creacion de cuenta | now now Prueba Tecnica ');
        });

        return response()->json(['success' => true, 'message' => 'Usuario creado correctamente'], 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_temporal' => ['required'],

        ]);

        $user = auth()->user();

        /* Actualizar usuario */
        if (!Gate::allows('update', [User::class, $user])) {
            return response()->json(['success' => false, 'error' => 'La constraseña solo se puede editar una vez'], 403);
        }
        if (!Hash::check($request->password_temporal, $user->password)) {
            return response()->json(['success' => false, 'error' => 'La contraseña temporal es incorrecta'], 403);
        }
        $user->password = Hash::make($request->password);
        $user->defaultPassword = 0;
        $user->save();
        return response()->json(['success' => true, 'message' => 'Contraseña actualizada correctamente'], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        //
    }
}
