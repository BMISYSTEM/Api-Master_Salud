<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_marca',
        'id_promocion',
        'estado',
        'nombre',
        'precio',
        'imagen1',
        'imagen2',
        'imagen3',
        'imagen4',
        'ficha_tecnica',
        'uso_adecuado',
        'aviso_legal',
        'caracteristica'
    ];
}
