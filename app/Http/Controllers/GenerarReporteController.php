<?php

namespace App\Http\Controllers;

use App\Jobs\ReporteAdminJob;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GenerarReporteController extends Controller
{



    public function index(Request $request)
    {

        if (!Gate::allows('create', Tarea::class)) {
            return response()->json(['success' => false, 'error' => 'No tiene permisos para crear reportes'], 403);
        }
        // **Usar `dispatchNow` para obtener el valor del job**

        $reporteTareas = Tarea::whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin])->get();


        $reporte = [
            'titulo' => 'Reporte de Tareas',
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'tareas' => [],
        ];

        foreach ($reporteTareas as $tarea) {
            $diferenciaMinutos = 0;
            $dias = 0;
            $horas = 0;
            $minutos = 0;

            if ($tarea->estado->id == 4) {
                $diferenciaMinutos = $tarea->created_at->diffInMinutes($tarea->updated_at);
                $dias = floor($diferenciaMinutos / 1440);
                $horas = floor(($diferenciaMinutos % 1440) / 60);
                $minutos = $diferenciaMinutos % 60;
            }

            $reporte['tareas'][] = [
                'titulo' => $tarea->titulo,
                'descripcion' => $tarea->descripcion,
                'estado' => $tarea->estado->nombre,
                'tiempo' => $tarea->estado->id == 4 ? "$dias días, $horas horas, $minutos minutos" : '-',
                'usuario' => $tarea->user->name,
            ];
        }
        if (count($reporte['tareas']) == 0) {
            return response()->json(['success' => false, 'error' => 'No hay tareas en el rango de fechas seleccionado'], 404);
        }
        ReporteAdminJob::dispatch($request->fecha_inicio, $request->fecha_fin,auth()->user());
        return response()->json(['success' => true, 'reporte' => $reporte,'message'=> 'Reporte generado y enviado al correo'], 200);
    }
}
