<?php

namespace App\Http\Controllers\Caracteristicas;

use App\Http\Controllers\Controller;
use App\Models\caracteristica;
use Illuminate\Http\Request;

class CaracteristicasController extends Controller
{
    // crear 
    public function createCaract(Request $request) {
        try {
            $data = $request->validate(
                [
                    'nombre'=>'required'
                ],
                [
                    'nombre.required'=>'El nombre es obligatorio'
                ]
            );
            $carct = caracteristica::create(
                [
                    'nombre'=>$data['nombre']
                ]
            );
            return response()->json(['succes'=>'Se creo de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Error inesperado en el servidor '.$th]);
        }
    }


    //  eliminar 
    public function deleteCarat(Request $request)
    {
        try {
            $data = $request->validate(
                [
                    'id'=>'required'
                ],
                [
                    'id.required'=>'El id es obligatorio'
                ]
            );
            $carct = caracteristica::find($data['id'])->delete();
            return response()->json(['succes'=>'Se Elimino de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Error inesperado en el servidor '.$th]);
        }
    }


    // consultar 

    public function allcaract()
    {
        $data = caracteristica::all();
        return response()->json(['succes'=>$data]);
    }

    public function update(Request $request)
    {
        $data = $request->validate(
            [
                'nombre'=>'required',
                'id'=>'required'
            ]
        );
        try {
            $caract = caracteristica::find($data['id']);
            $caract->nombre = $data['nombre'];
            $caract->save();
            return response()->json(['succes'=>'Caracteristica editada de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Error insesperado en el servidor '.$th],500);
        }
    }
}