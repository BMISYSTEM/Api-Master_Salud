<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'primera_visita',
        'fecha_cita',
        'observacion',
        'horario',
        'motivo',
        'user'
    ];
}
