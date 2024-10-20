<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class venta_producto extends Model
{
    use HasFactory;

    protected $fillable =[
        'factura',
        'producto',
        'promocion',
        'marca',
        'valor_unitario',
        'procentaje_aplicado',
    ];
}
