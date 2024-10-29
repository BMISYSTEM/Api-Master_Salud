<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class informacion_medico extends Model
{
    use HasFactory;

    protected $fillable = [
        'presentacion',
        'especialidad',
        'atencion',
        'publico',
        'medios_pago',
        'medios_pago',
        'foto1',
        'foto2',
        'foto3',
        'foto4',
        'foto5',
        'foto6',
        'foto7',
        'foto8',
        'user'

    ];
}
