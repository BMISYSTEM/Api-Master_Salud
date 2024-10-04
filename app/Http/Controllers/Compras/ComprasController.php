<?php
namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Mail\MasterSalud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ComprasController extends Controller
{
    public function newCompra(Request $request)
    {
        try {
            //code...
            Mail::to('baironmenesesidarraga.990128@gmail.com')->send(new MasterSalud());
            if (Mail::failures()) {
                return response()->json(['error' => 'El correo no se pudo enviar'], 500);
            }
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