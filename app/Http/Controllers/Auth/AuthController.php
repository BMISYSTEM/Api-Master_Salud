<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function Auth(Request $request)
    {
        $request = $request->validate(
            [
                'email'=>'required|email',
                'password'=>'required|min:6'
            ],
            [
                'email.exists'=>'El email no existe',
                'email.required'=>'El email es obligatorio',
                'email.email'=>'El email no tiene un formato valido',
                'password.required'=>'El password es obligatorio'
            ]
        );

        try {
            //code...
            if(!Auth::attempt($request))
            {   
                return response()->json(['error'=>'El password es incorrecto']);
            }
            $user = Auth::user();
            $token = $user->createToken('token')->plainTextToken;
            return response()->json(['succes'=>$token]);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th],200);
            //throw $th;
        }
    }




}