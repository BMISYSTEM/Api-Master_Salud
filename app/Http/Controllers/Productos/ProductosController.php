<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use App\Models\producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
{
    public function createProducto(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'id_marca' => 'required|integer',
            'id_promocion' => 'required|integer',
            'precio' => 'required|numeric',
            'fotos' => 'required|array',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
        $rutas = [];
        try {
            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $imagen) {
                    $ruta = $imagen->store('fotos', 'public'); 
                    $rutas[] = $ruta;
                }
            }
            $producto = producto::create(
                [
                    'nombre'=>$request['nombre'],
                    'precio'=>$request['precio'],
                    'estado'=>1,
                    'id_marca'=>$request['id_marca'],
                    'id_promocion'=>$request['id_promocion'],
                    'valor'=>$request['valor'],
                    'imagen1'=>$rutas[0],
                    'imagen2'=>$rutas[1],
                    'imagen3'=>$rutas[2],
                    'imagen4'=>$rutas[3],
                ]
            );
            return response()->json(['succes'=>'Se creo el producto de forma correcta']);

        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se presento un error inesperado '.$th],500);
        }
    }

    public function updateProducto(Request $request)
    {
        $request = $request->validate(
            [
                'id_producto'=>'require|exists:productos,id',
                'id_marca'=>'require|exists:marcas,id',
                'nombre'=>'require',
                'precio'=>'require',
                'id_promocion'=>'require|exists:promociones,id',
                'estado'=>'require'
            ],
            [
                'id_producto.require'=>'El producto es obligatorio',
                'id_producto.exists'=>'EL producto no existe en la base de datos',
                'id_marca.require'=>'El id de la marca es obligatorio ',
                'id_marca.exists'=>'El id de la marca no existe',
                'nombre.require'=>'El nombre es obligatorio',
                'precio'=>'El precio es obligatorio',
                'id_promocion.require'=>'El id de la promocion es obligatorio',
                'id_promocion.exists'=>'El id de promocion no existe',
                'estado'=>'El estado es obligatorio'
            ]
        );
        try {
            $producto = producto::find($request['id_producto']);
            $producto->id_marca = $request['id_marca'];
            $producto->id_promocion = $request['id_promocion'];
            $producto->nombre = $request['nombre'];
            $producto->estado = $request['estado'];
            $producto->precio = $request['precio'];
            $producto->save();

            return response()->json(['succes'=>'Se actualizo el producto de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se presento un error inesperado '.$th]);
        }
    }

    public function deleteProducto(Request $request)
    {
        $request = $request->validate(
            [
                'id_producto'=>'require|exists:productos,id',
            ],
            [
                'id_producto.require'=>'El producto es obligatorio',
                'id_producto.exists'=>'EL producto no existe en la base de datos',
            ]
        );
        try {
            $producto = producto::find($request['id_producto'])->delete(); 
            return response()->json(['succes'=>'Se Elimino el producto de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se presento un error inesperado '.$th]);
        }
    }

    public function findProducto(Request $request)
    {
        $request = $request->validate(
            [
                'id_producto'=>'require|exists:productos,id',
            ],
            [
                'id_producto.require'=>'El producto es obligatorio',
                'id_producto.exists'=>'EL producto no existe en la base de datos',
            ]
        );
        try {
            $producto = producto::find($request['id_producto']); 
            return response()->json(['succes'=>$producto]);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se presento un error inesperado '.$th]);
        }
    }

    public function allProdcuto()
    {
        try {
            $producto = DB::select('select p.id,p.nombre,p.id_marca,m.nombre as nombre_marca,p.id_promocion,pr.porcentaje,pr.nombre as nombre_promocion,p.precio,p.estado  from productos p 
                        inner join marcas m on p.id_marca = m.id
                        inner join promociones pr on p.id_promocion = pr.id
                        '); 
            return response()->json(['succes'=>$producto]);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se presento un error inesperado '.$th]);
        }
    }
}