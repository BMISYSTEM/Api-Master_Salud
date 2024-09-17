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
        'precio'
    ];
}
