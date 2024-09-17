<?php

namespace App\Http\Controllers\Productos;

use App\Http\Controllers\Controller;
use App\Models\producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function createProducto(Request $request)
    {
        $request = $request->validate(
            [
                'id_marca'=>'require|exists:marcas,id',
                'nombre'=>'require',
                'precio'=>'require',
                'id_promocion'=>'require|exists:promociones,id',
                'estado'=>'require'
            ],
            [
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
            $producto = producto::create(
                [
                    'nombre'=>$request['nombre'],
                    'precio'=>$request['precio'],
                    'estado'=>$request['estado'],
                    'id_marca'=>$request['id_marca'],
                    'id_promocion'=>$request['id_promocion']
                ]
            );
            return response()->json(['succes'=>'Se creo el producto de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se presento un error inesperado '.$th]);
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
            $producto = producto::all(); 
            return response()->json(['succes'=>$producto]);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se presento un error inesperado '.$th]);
        }
    }
}