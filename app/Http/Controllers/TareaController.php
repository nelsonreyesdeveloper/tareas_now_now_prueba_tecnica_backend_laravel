<?php

namespace App\Http\Controllers;

use App\Http\Requests\TareaRequest;
use App\Models\Estado;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $titulo = $request->get('titulo');

        $tareas = Tarea::with('comentarios.user', 'archivos.user','user')
            ->when($titulo, function ($query) use ($titulo) {
                $query->where('titulo', 'like', '%' . $titulo . '%');
            })
            ->paginate($request->page ?? 10);

        return response()->json([
            'success' => true,
            'tareas' => $tareas,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TareaRequest $request)
    {

        if (!Gate::allows('create', Tarea::class)) {
            return response()->json(['success' => false, 'error' => 'No tiene permisos para crear tareas'], 403);
        }

        $estadoid = strlen($request->get('estado_id')) == 0 ? 1 : $request->get('estado_id');

        $tarea = Tarea::create([
            'titulo' => $request->get('titulo'),
            'descripcion' => $request->get('descripcion'),
            'estado_id' => $estadoid,
            'user_id' => $request->get('user_id'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tarea creada correctamente',
        ]);
    }

    public function modifyEmployee(Request $request, $id)
    {

        $tarea = Tarea::find($id);


        if (!$tarea) {
            return response()->json(['success' => false, 'error' => 'La tarea no existe'], 404);
        }

        if (!Gate::allows('modifyEmployeeTask', [Tarea::class, $tarea ?? null])) {
            return response()->json(['success' => false, 'error' => 'No tiene permisos para modificar cambiar el empleado de la tarea'], 403);
        }



        $user = User::find($request->get('user_id'));
        if (!$user) {
            return response()->json(['success' => false, 'error' => 'El usuario no existe'], 404);
        }

        $tarea->user_id = $request->get('user_id');
        $tarea->save();

        return response()->json([
            'success' => true,
            'message' => 'Tarea actualizada correctamente',
        ], 201);
    }



    /**
     * Update the specified resource in storage.
   
     */
    public function update(Request $request, $id)
    {
        //  Los empleados únicamente pueden modificar el estado de sus tareas asignadas (Super admins
        //          pueden modificar cualquiera)

        $tarea = Tarea::find($id);

        $tarea_estado_before = $tarea->estado_id ?? null;

        if (!$tarea) {
            return response()->json(['success' => false, 'error' => 'La tarea no existe'], 404);
        }

        if (!Gate::allows('update', [Tarea::class, $tarea])) {
            return response()->json(['success' => false, 'error' => 'No tiene permisos para cambiar el estado de la tarea'], 403);
        }

        $estadoid = Estado::find($request->get('estado_id'));
        if (strlen($estadoid) == 0) {
            return response()->json(['success' => false, 'error' => 'No se ha seleccionado un estado o no es valido'], 400);
        }

        $tarea->estado_id = $request->get('estado_id');
        $tarea->save();

        return response()->json([
            'success' => true,
            'message' => 'Tarea actualizada correctamente',
        ], 201);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea, $id)
    {
        // Validar si la tarea existe

        $tarea = Tarea::find($id);


        // Validar si el usuario tiene permiso para eliminar
        if (!Gate::allows('delete', [Tarea::class, $tarea])) {
            return response()->json(['success' => false, 'error' => 'No tiene permisos para eliminar esta tarea'], 403);
        }

        if (!$tarea) {
            return response()->json(['success' => false, 'error' => 'La tarea no existe'], 404);
        }
        // ... resto del código para eliminar la tarea ...

        // Responder con éxito o error
        return response()->json([
            'success' => true,
            'message' => 'Tarea eliminada correctamente',
        ], 200);
    }
}
