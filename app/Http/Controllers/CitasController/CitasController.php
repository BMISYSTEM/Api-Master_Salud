<?php

namespace App\Http\Controllers\CitasController;

use App\Http\Controllers\Controller;
use App\Mail\agndarCita;
use App\Models\cita;
use App\Models\horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CitasController extends Controller
{
    //crear publica
    public function createCita(Request $request)
    {
        $data = $request->validate(
            [
                    'nombre'=>'required',
                    'telefono'=>'required',
                    'email'=>'required',
                    'primera_visita'=>'required',
                    'fecha_cita'=>'required',
                    'observacion'=>'required',
                    'horario'=>'required',
                    'motivo'=>'required',
                    'user'=>'required'
            ]
        );

        try {
            $cita = cita::create(
                [
                    'nombre'=>$data['nombre'],
                    'telefono'=>$data['telefono'],
                    'email'=>$data['email'],
                    'primera_visita'=>$data['primera_visita'],
                    'fecha_cita'=>$data['fecha_cita'],
                    'observacion'=>$data['observacion'],
                    'horario'=>$data['horario'],
                    'motivo'=>$data['motivo'],
                    'user'=>$data['user']
                ]
            );
            $horario = horario::find($data['horario']);
            Mail::to($data['email'])->send(new agndarCita($data,$horario));
            return response()->json(['succes'=>'Se registro la cita de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Error generado al momento de mandar la cita//'.$th],500);
        }
    }
    //eliminar

    //marcar atendida

    //consultar todas
}