<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombreUnico',
        'nombreOriginal',
        'tipo',
        'tamanio',
        'ruta',
        'user_id',
        'tarea_id',
    ];

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
