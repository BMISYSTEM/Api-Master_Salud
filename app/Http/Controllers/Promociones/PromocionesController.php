<?php

namespace App\Http\Controllers\Promociones;

use App\Http\Controllers\Controller;
use App\Models\promocione;
use Illuminate\Http\Request;

class PromocionesController extends Controller
{
    public function createPromocion(Request $request)
    {
        $request = $request->validate(
            [
                'nombre' =>'require',
                'porcentaje'=>'require|min:0|max:100',
                'activo'=>'require'
            ],
            [
                'nombre.require' =>'EL nombre es requerido',
                'porcentaje.require'=>'EL procentaje es requerido',
                'porcentaje.require'=>'EL procentaje es requerido',
                'activo'=>'require'
            ]
        );
        try {
            $promocion = promocione::create(
                [
                    'nombre'=>$request['nombre'],
                    'porcentaje'=>$request['porcentaje'],
                    'activo'=>$request['activo']
                ]
            );
            return response()->json(['succes'=>'Se creo la prmocion de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se presento un error inesperado '.$th]);
        }
    }
    public function updatePromocion(Request $request)
    {
        $request = $request->validate(
            [
                'id'=>'required|exists:promociones,id',
                'nombre' =>'require',
                'porcentaje'=>'require|min:0|max:100',
                'activo'=>'require'
            ],
            [
                'id.require'=>'El id es obligatorio',
                'id.exists'=>'El id proporcionado no existe',
                'nombre.require' =>'EL nombre es requerido',
                'porcentaje.require'=>'EL procentaje es requerido',
                'porcentaje.require'=>'EL procentaje es requerido',
                'activo'=>'require'
            ]
        );
        try {
            $promocion = promocione::find($request['id']);
            $promocion->nombre = $request['nombre'];
            $promocion->porcentaje = $request['porcentaje'];
            $promocion->activo = $request['activo'];
            $promocion->save();
            return response()->json(['succes'=>'Se actualizo de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se presento un error inesperado '.$th]);
        }
    }
    public function deletePromocion(Request $request)
    {
        $request = $request->validate(
            [
                'id'=>'required|exists:promociones,id',
            ],
            [
                'id.require'=>'El id es obligatorio',
                'id.exists'=>'El id proporcionado no existe',
            ]
        );
        try {
            $promocion = promocione::find($request['id'])->delete();
            return response()->json(['succes'=>'Se Elimino la promocion de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se presento un error inesperado '.$th]);
        }
    }

    public function findPromocion(Request $request)
    {
        $request = $request->validate(
            [
                'id'=>'required|exists:promociones,id',
            ],
            [
                'id.require'=>'El id es obligatorio',
                'id.exists'=>'El id proporcionado no existe',
            ]
        );
        try {
            $promocion = promocione::find($request['id']);
            return response()->json(['succes'=>$promocion]);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se presento un error inesperado '.$th]);
        }
    }
    public function allPromociones()
    {
        try {
            $promocion = promocione::all();
            return response()->json(['succes'=>$promocion]);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se presento un error inesperado '.$th]);
        }
    }
}