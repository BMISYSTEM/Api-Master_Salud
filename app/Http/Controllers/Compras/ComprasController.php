<?php
namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Mail\MasterSalud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class ComprasController extends Controller
{
    public function newCompra(Request $request)
    {
        $data = $request->validate(
            [
                'id'=>'required',
                'status'=>'required',
                'reference'=>'required',
                'productos'=>'required',
                'valort'=>'required',
                'token'=>'required',
                'nombre'=>'required',
                'apellido'=>'required',
                'email'=>'required',
                'ciudad'=>'required',
                'direccion'=>'required',
                'telefono'=>'required'
            ],
            [
                'id.required'=>'El campo id es obligatorio no se completo la compra.',
                'status.required'=>'El campo status es obligatorio no se completo la compra.',
                'reference.required'=>'El campo reference es obligatorio no se completo la compra.',
                'productos.required'=>'El campo productos es obligatorio no se completo la compra.',
                'valort.required'=>'El campo valort es obligatorio no se completo la compra.',
                'token.required'=>'El campo token es obligatorio no se completo la compra.',
                'nombre.required'=>'El campo nombre es obligatorio no se completo la compra.',
                'apellido.required'=>'El campo apellido es obligatorio no se completo la compra.',
                'email.required'=>'El campo email es obligatorio no se completo la compra.',
                'ciudad.required'=>'El campo ciudad es obligatorio no se completo la compra.',
                'direccion.required'=>'El campo direccion es obligatorio no se completo la compra.',
            ]
        );
        $factura = Str::uuid();
        $product = $data['productos'];
        try {
            //code...
            Mail::to($data['email'])->send(new MasterSalud($data,$factura,$product ));
            return response()->json(['succes'=>'correo enviado']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'error' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'trace' => $th->getTraceAsString()
            ], 500);
        }
    }
}