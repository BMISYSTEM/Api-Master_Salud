<?php

namespace App\Http\Controllers\Especialidades;

use App\Http\Controllers\Controller;
use App\Models\especialidade;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class EspecialidadesController extends Controller
{


    public function  createEspecialidad(Request $request)
    {
        $data = $request->validate(
            [
                'nombre' =>'required'
            ]
        );
        try {
            $espe = especialidade::create(
                [
                    'nombre'=>$data['nombre']
                ]
            );
            return response()->json(['succes'=>'se creo de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'error inesperado '.$th],500);
        }
    }

    public function updateEspecialidad(Request $request)
    {
        $data = $request->validate([
            'id'=>'required',
            'nombre'=>'required'
        ]);

        try {
            $espe = especialidade::find($data['id']);
            $espe->nombre = $data['nombre'];
            $espe->save();
            return response()->json(['succes'=>'Se actualizo de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Error inesperado '.$th],500);
        }
    }

    public function deleteEspecialidad(Request $request)
    {
        $data =  $request->validate(
            [
                'id'=>'required'
            ]
        );
        try {
            $espe = especialidade::find($data['id'])->delete();
            return response()->json(['succes'=>'Se elimino de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Error inesperado '.$th],500);
        }
    }

    public function all()
    {
        return response()->json(['succes'=>especialidade::all()]);
    }

}