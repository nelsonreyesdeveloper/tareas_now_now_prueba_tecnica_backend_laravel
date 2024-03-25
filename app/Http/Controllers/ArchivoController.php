<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArchivoController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Archivo $archivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Archivo $archivo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Archivo $archivo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,  $id)
    {
        $request->validate([
            'tarea_id',
        ]);

        $archivo = Archivo::find($id);
        if (!$archivo) {
            return response()->json(['success' => false, 'error' => 'El archivo no existe'], 404);
        }
        $tarea = Tarea::find($request->get('tarea_id'));

        if (!$tarea) {
            return response()->json(['success' => false, 'error' => 'La tarea no existe'], 404);
        }

        if (!Gate::allows('delete', [Archivo::class, $archivo, $tarea])) {
            return response()->json(['success' => false, 'error' => 'No tiene permisos para eliminar este archivo'], 403);
        }
        $archivo->delete();
    }
}
