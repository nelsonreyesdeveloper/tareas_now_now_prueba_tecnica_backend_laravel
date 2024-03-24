<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $user->with('roles')
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Sesion finalizada'], 200);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();


        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        $password_reset_token_anterior = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if ($password_reset_token_anterior) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        }

        // Generar un token de reinicio de contraseña
        $token = Str::random(15);

        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
        ]);

        $user['token'] = $token;

        // Enviar un correo electrónico con el enlace de restablecimiento de contraseña
        Mail::send('emails.password_reset', ['user' => $user], function ($message) use ($user) {
            $message->to($user->email)->subject('Restablecimiento de contraseña');
        });

        return response()->json(['message' => 'Se ha enviado un correo electrónico con las instrucciones para restablecer la contraseña'], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate(['email' => 'required|email', 'token' => 'required', 'password' => 'required|confirmed|min:8',]);

        $user = User::where('email', $request->email)->first();

        /* BUSCAR EN LA TABLA PASSWORD_RESET_TOKENS EL TOKEN */

        $password_reset_token = DB::table('password_reset_tokens')->where('email', $request->email)->first();


        if (!$user || !Hash::check($request->token, $password_reset_token->token)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada correctamente'], 200);
    }
}
