<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function Auth(Request $request)
    {
        $request = $request->validate(
            [
                'email'=>'required|email|exists:users,email',
                'password'=>'required|min:6'
            ],
            [
                'email.exists'=>'El email no existe',
                'email.required'=>'El email es obligatorio',
                'email.email'=>'El email no tiene un formato valido',
                'password.required'=>'El password es obligatorio'
            ]
        );

        if(!Auth::attempt($request))
        {   
            return response()->json(['error'=>'El email o el password son incorrectos']);
        }
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        return response()->json(['succes'=>$token]);
    }




}