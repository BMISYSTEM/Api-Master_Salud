<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\banner;
use App\Models\home;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /* crear imagen de fondo */
    public function create(Request $request)
    {
        $data = $request->validate(
            [
                'fondo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'fondo.required' => 'El campo fondo es obligatorio.',
                'fondo.image' => 'El archivo debe ser una imagen válida.',
                'fondo.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o gif.',
                'fondo.max' => 'La imagen no debe exceder los 2 MB.',
            ]
        );
        $ruta = $data['fondo']->store('fotos', 'public'); 
        try {
           $home = home::find(1);
           $home->fondo = $ruta;
           $home->save();
            return response()->json(['succes'=>'Se Guardo de forma correcat la imagen']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se genero un error inesperado en el servidor '.$th],500);
        }
    }
    public function banner(Request $request)
    {
        $data = $request->validate(
            [
                'fondo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'fondo.required' => 'El campo fondo es obligatorio.',
                'fondo.image' => 'El archivo debe ser una imagen válida.',
                'fondo.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o gif.',
                'fondo.max' => 'La imagen no debe exceder los 2 MB.',
            ]
        );
        $ruta = $data['fondo']->store('fotos', 'public'); 
        try {
           $banner = banner::find(1);
           $banner->imagen = $ruta;
           $banner->save();
            return response()->json(['succes'=>'Se Guardo de forma correcat la imagen']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se genero un error inesperado en el servidor '.$th],500);
        }
    }



    public function all()
    {
        $data = home::all();
        $banner = banner::all();
        return response()->json(['succes'=>$data,'banner'=>$banner]);
    }
}