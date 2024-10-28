<?php 

namespace App\Http\Controllers\Motivos;

use App\Http\Controllers\Controller;
use App\Models\motivos_consulta;
use Illuminate\Http\Request;

class MotivosController extends Controller 
{
    public function newMotivo(Request $request )
    {
        $data = $request->validate(
            [
                'nombre'=>'required'
            ]
        );

        try {
            $motivo = motivos_consulta::create(
                [
                    'nombre'=>$data['nombre']
                ]
            );
            return response()->json(['succes'=>'Se creo de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'se genero un error inesperado '.$th]);
        }
    }

    public function deleteMotivo(Request $request)
    {
        $data = $request->validate(
            [
                'id'=>'required|exists:motivos_consultas,id'
            ]
        );
        try {
            $motivo = motivos_consulta::find($data['id'])->delete();
            return response()->json(['succes'=>'Se elimino de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'se genero un error inesperado '.$th]);
        }
    }

    public function allMotivo()
    {
        $motivos = motivos_consulta::all();
        return response()->json(['succes'=>$motivos]);
    }
    
}