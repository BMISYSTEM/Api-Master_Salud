<?php 

namespace App\Http\Controllers\Motivos;

use App\Http\Controllers\Controller;
use App\Models\motivos_consulta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MotivosController extends Controller 
{
    public function newMotivo(Request $request )
    {
        $data = $request->validate(
            [
                'nombre'=>'required'
            ]
        );
        $id = Auth::user()->id;
        try {
            $motivo = motivos_consulta::create(
                [
                    'nombre'=>$data['nombre'],
                    'user'=>$id
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