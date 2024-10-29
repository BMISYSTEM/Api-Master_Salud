<?php 

namespace App\Http\Controllers\Horarios;

use App\Http\Controllers\Controller;
use App\Models\horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HorariosController extends Controller 
{


    public function createHorario(Request $request) 
    {
        $data = $request->validate(
            [
                'hora_inicio'=>'required',
                'hora_fin'=>'required',
                'lunes'=>'required',
                'martes'=>'required',
                'miercoles'=>'required',
                'jueves'=>'required',
                'viernes'=>'required',
                'sabado'=>'required',
                'domingo'=>'required',
            ]
        );
        $id = Auth::user()->id;
        try {
            //code...
            $horario = horario::create(
                [
                    'hora_inicio'=>$data['hora_inicio'],
                    'hora_fin'=>$data['hora_fin'],
                    'lunes'=>$data['lunes'],
                    'martes'=>$data['martes'],
                    'miercoles'=>$data['miercoles'],
                    'jueves'=>$data['jueves'],
                    'viernes'=>$data['viernes'],
                    'sabado'=>$data['sabado'],
                    'domingo'=>$data['domingo'],
                    'user'=>$id
                ]
            );
            return response()->json(['succes'=>'horario creado con exito']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error'=>'Error inesperado en el servidor '.$th]);
        }
    }

    public function deleteHorario(Request $request) 
    {
        $data = $request->validate(
            [
                'id'=>'required|exists:horarios,id',
            ]
        );

        try {
            //code...
            $horario = horario::find($data['id'])->delete();
            return response()->json(['succes'=>$horario]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error'=>'Error inesperado en el servidor '.$th]);
        }
    }
    public function horarioAll() 
    {
        try {
            //code...
            $id = Auth::user()->id;
            $horario = horario::where('user',$id)->get();
            return response()->json(['succes'=>$horario]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error'=>'Error inesperado en el servidor '.$th]);
        }
    }



}