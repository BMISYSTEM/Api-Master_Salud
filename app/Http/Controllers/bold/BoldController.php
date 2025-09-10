<?php

namespace App\Http\Controllers\bold;

use App\Http\Controllers\Controller;
use App\Models\producto;
use App\Models\promocione;
use App\Models\venta;
use App\Models\venta_producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BoldController extends Controller
{
    public $llavePriv = "ZrcfZ8muObQpynJx9Lqh6JnFH7u3Ou9C4afiBZZtn7E";
    public $baseUrl = "https://integrations.api.bold.co";
    /* consulta los metodos de pago  */
    function metodosPago(Request $request)
    {
        $key = $this->llavePriv;
        $data = Http::withHeaders([
            "Authorization" => "x-api-key $key",
            "Accept" => "application/json",
        ])->get($this->baseUrl . "/payments/payment-methods");
        return response()->json($data->json());
    }
    function terminales()
    {
        $endpoint = "/payments/binded-terminals";
        $key = $this->llavePriv;
        $data = Http::withHeaders([
            "Authorization" => "x-api-key $key",
            "Accept" => "application/json",
        ])->get($this->baseUrl . $endpoint);
        return response()->json($data->json());
    }
    function createLinkPago(Request $request)
    {
        $productos = $request["productos"];
        $endpoint = "/online/link/v1";
        $key = $this->llavePriv;
        $currentNanoseconds = microtime(true) * 1e9; // Convertir microsegundos a nanosegundos
        $tenMinutesInNanoseconds = 10 * 60 * 1e9; // 10 minutos en nanosegundos
        $futureNanoseconds = $currentNanoseconds + $tenMinutesInNanoseconds;
        
        /* consultar el valor de los productos  y totalizarlo */
        $valorTotal = 0;
        $descripcion = "";
        foreach ($productos as $producto) {
            $product = producto::find($producto["id"]);
            $promocion = promocione::find($product["id_promocion"]);
            if($product){
                $descripcion .= $product["nombre"] . ", ";
                $valorTotal += $product["precio"] -  ($product["precio"] * ($promocion["porcentaje"] / 100)) ;
            }
        }
        $array = [
            "amount_type" => "CLOSE",
            "amount" => [
                "currency" => "COP",
                "tip_amount" => 0,
                "total_amount" => $valorTotal,
            ],
            "expiration_date" => $futureNanoseconds,
            "payment_method" => ["POS"],
            "description" => $descripcion,
            "callback_url" => "https://medicalgroup.com.co/productos",
            "payer_email" => $request["email"],
        ];
        $data = Http::withHeaders([
            "Authorization" => "x-api-key $key",
            "Accept" => "application/json",
        ])->post($this->baseUrl . $endpoint, $array);
        $res = $data->json();
        $venta = venta::create(
            [
                "factura"=>$res["payload"]["payment_link"],
                "email_cliente"=>$request["email"],
                "telefono_cliente"=> $request["telefono"],
                "direccion"=>$request["direccion"],
                "nombre"=>$request["nombre"],
                "apellidos"=>$request["apellido"],
                "status_pago"=>0,
                "status_entrega"=>0,
            ]
        );
        /* detalle de la venta  */
         foreach ($productos as $producto) {
            $product = producto::find($producto["id"]);
            $promocion = promocione::find($product["id_promocion"]); 
            $detalle = venta_producto::create(
                [
                        'factura'=>$res["payload"]["payment_link"],
                        'producto'=>$product["id"],
                        'promocion'=>$promocion["id"],
                        'marca'=>$product["id_marca"],
                        'cantidad'=>$producto["cantidad"],
                        'valor_unitario'=>$product["precio"],
                        'procentaje_aplicado'=>$promocion["porcentaje"],
                ]
            );
        }
        return response()->json($res);
    }
    
    function statusUpdate(Request $request)
    {
        /* $factura = factura::where("idLink", $request["id"])->first();
        $factura->estado = $request["status"] == "approved" ? 1 : 0;
        $factura->save();
        return response()->json([
            "succes" => "estado actualizado correctamente ",
        ]); */
    }

    function facturasAll()
    {
        /* $empresas = Auth::user()->empresas;
        $factura = factura::where("empresas", $empresas)->get();
        return response()->json($factura); */
    }


    function webHookBold(Request $request)
    {
        $paimentId = $request["data"]["payment_id"];
        $status = $request["type"];
        $venta = venta::where("link_id",$paimentId)->first();
        $venta->status_pago = $status;
        $venta->save();
        return true;
    }
}
