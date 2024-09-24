<?php 

namespace App\Http\Controllers\Marcas;

use App\Http\Controllers\Controller;
use App\Models\marca;
use Illuminate\Http\Request;

class MarcasController extends Controller
{
    /**
     * Creacion de marca
     */
    public function createMarca(Request $request)
    {
        $request = $request->validate(
            [
                'nombre' => 'required|min:3|max:50'
            ],
            [
                'nombre.required'=>'El nombre es obligatorio',
                'nombre.min'=>'El nombre es muy corto',
                'nombre.max'=>'El nombre es muy largo'
            ]
        );
        try {
            $marcas = marca::create(
                [
                    'nombre'=>$request['nombre']
                ]
            );
            return response()->json(['succes'=>'Se creo de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se presento un error inesperado '.$th]);
        }
    }
    /**
     * Actualiza una marca
     */
    public function updateMarca(Request $request)
    {
        $request = $request->validate(
            [
                'id'=>'required|exists:marcas,id',
                'nombre' => 'required|min:3|max:50'
            ],
            [
                'id.required'=>'El nombre es obligatorio',
                'id.exists'=>'El id no existe',
                'nombre.required'=>'El nombre es obligatorio',
                'nombre.min'=>'El nombre es muy corto',
                'nombre.max'=>'El nombre es muy largo'
            ]
        );
        try {
            $marcas = marca::find($request['id']);
            $marcas->nombre = $request['nombre'];
            $marcas->save();
            return response()->json(['succes'=>'Se actualizo una marca']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se presento un error inesperado '.$th]);
        }
    }
    /**
     * Elimina una marca
     */
    public function deleteMarca(Request $request)
    {
        $request = $request->validate(
            [
                'id'=>'required|exists:marcas,id',
            ],
            [
                'id.required'=>'El nombre es obligatorio',
                'id.exists'=>'El id no existe',
            ]
        );
        try {
            $marcas = marca::find($request['id'])->delete();
            return response()->json(['succes'=>'Se elimino una marca']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se presento un error inesperado '.$th],500);
        }
        
    }
    /**
     * Consulta una marca
     */
    public function findMarca(Request $request)
    {
        $request = $request->validate(
            [
                'id'=>'required|exists:marcas,id',
            ],
            [
                'id.required'=>'El nombre es obligatorio',
                'id.exists'=>'El id no existe',
            ]
        );
        $marcas = marca::find($request['id']);
        return response()->json(['succes'=>$marcas]);
    }
    /**
     * Consulta todas las marcas
     */
    public function allMarca()
    {
        $marcas = marca::all();
        return response()->json(['succes'=>$marcas]);
    }

}

