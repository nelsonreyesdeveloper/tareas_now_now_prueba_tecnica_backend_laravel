<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Tarea;
use Illuminate\Http\Request;

class ComentarioController extends Controller
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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'comentario' => 'required',
            'tarea_id' => 'required',
        ]);

        $tarea = Tarea::find($request->tarea_id);

        if (!$tarea) {
            return response()->json([
                'success' => false,
                'message' => 'Tarea no encontrada'
            ], 404);
        }

        $comentario = Comentario::create([
            'comentario' => $request->comentario,
            'tarea_id' => $request->tarea_id,
            'user_id' => auth()->user()->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comentario creado',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comentario $comentario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comentario $comentario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comentario $comentario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {


        $this->validate($request, [
            'comentario_id' => 'required',
            'tarea_id' => 'required'
        ]);


        $tarea = Tarea::find($request->tarea_id);

        if (!$tarea) {
            return response()->json([
                'success' => false,
                'message' => 'Tarea no encontrada'
            ], 404);
        }

        $comentario = Comentario::find($request->comentario_id);

        if (!$comentario) {
            return response()->json([
                'success' => false,
                'message' => 'Comentario no encontrado'
            ], 404);
        }

        if ($comentario->user_id != auth()->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para eliminar este comentario'
            ], 403);
        }


        $comentario->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comentario eliminado'
        ]);
    }
}
