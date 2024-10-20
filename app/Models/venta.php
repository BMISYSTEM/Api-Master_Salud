<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class venta extends Model
{
    use HasFactory;


    protected $fillable =[
        'factura',
        'email_cliente',
        'telefono_cliente',
        'direccion',
        'nombre',
        'apellidos',
        'status_pago',
        'status_entrega',
    ];
}
