<?php

namespace App\Jobs;

use App\Models\Tarea;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ReporteAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $fecha_inicio;
    private $fecha_fin;
    private $user;
    /**
     * Create a new job instance.
     */
    public function __construct($fecha_inicio, $fecha_fin, $user)
    {
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->user = $user;
    }


    /**
     * Execute the job.
     */
    public function handle()
    {

        $data = [
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'name' => $this->user->name,
        ];


        $user = auth()->user();
        Mail::send('reportes.super_admin', ['data' => $data], function ($message) use ($user) {
            $message->to($user->email)->subject('Nuevo reporte de tareas');
        });
    }
}
