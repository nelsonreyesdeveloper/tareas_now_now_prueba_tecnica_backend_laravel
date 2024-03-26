<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Visibility; // Import the Visibility class

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
    public function store(Request $request)
    {
        // Validar la solicitud
        $this->validate($request, [
            'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png',
            'tarea_id' => 'required',

        ]);

        // Obtener la tarea
        $tarea = Tarea::find($request->tarea_id);

        // Verificar que la tarea exista
        if (!$tarea) {
            return response()->json([
                'success' => true,
                'message' => 'La tarea no existe',
            ], 404);
        }
        // Almacenar el archivo en el servidor
        $archivo = $request->file('archivo');

        $nombreOriginal = $archivo->getClientOriginalName();
        // Obtener información del archivo

        $nombreUnico = md5($nombreOriginal . time());
        $tipo = $archivo->getClientOriginalExtension();
        $tamanio = $archivo->getSize();

        // Check if folder exists, create if not
        if (!Storage::disk('public')->exists('archivos-adjuntos')) {
            Storage::disk('public')->makeDirectory('archivos-adjuntos');
        }

        // Store the file
        try {
            $rutaArchivo = Storage::disk('public')->put('archivos-adjuntos', $archivo);
        } catch (\Exception $e) {
            Log::error('Error al guardar archivo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar archivo',
            ], 500);
        }

        $pathinfo = pathinfo($rutaArchivo);

      
        // Crear un nuevo modelo de archivo adjunto
        $archivoAdjunto = new Archivo([
            'nombreUnico' => $pathinfo['filename'],
            'nombreOriginal' => $nombreOriginal,
            'tipo' => $tipo,
            'tamanio' => $tamanio,
            'ruta' => $rutaArchivo,
            'tarea_id' => $request->tarea_id,
            'user_id' => auth()->user()->id,

        ]);

        // Guardar el modelo
        $archivoAdjunto->save();

        // Retornar una respuesta exitosa
        return response()->json([
            'success' => true,
            'message' => 'Archivo adjunto creado correctamente',
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Archivo $archivo)
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
