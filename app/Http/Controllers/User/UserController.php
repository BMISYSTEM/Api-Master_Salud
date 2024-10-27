<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        $request = $request->validate(
            [
                'nombre' => 'required',
                'apellido' => 'required',
                'cedula' => 'required',
                'fijo' => 'required',
                'telefono' => 'required',
                'direccion' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                
            ],
            [
                'nombre.required' => 'El nombre es requerido',
                'apellido.required' => 'El apellido es requerido',
                'cedula.required' => 'El cedula es requerido',
                'fijo.required' => 'El fijo es requerido',
                'telefono.required' => 'El telefono es requerido',
                'direccion.required' => 'El direccion es requerido',
                'email.required' => 'El email es obligatorio',
                'email.uniqued' =>'El email ya existe ',
                'email.email' => 'El email no tiene un formato valido',
                'password.required' => 'El password es obligatorio'
            ]
        );
        try {
            $user = User::create(
                [
                    'name'=>$request['nombre'],
                    'apellido'=>$request['apellido'],
                    'cedula'=>$request['cedula'],
                    'direccion'=>$request['direccion'],
                    'fijo'=>$request['fijo'],
                    'celular'=>$request['telefono'],
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                ]
            );
            return response()->json(['succes' => 'Usuario creado de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Se genero un error inesperado ' . $th],500);
        }
    }

    public function UpdateUser(Request $request)
    {
        $request = $request->validate(
            [
                'id' => 'require|exists:users,id',
                'name' => 'require',
                'emai' => 'require|email',
            ],
            [
                'id.require' => 'El id es obligatorio',
                'id.exists' => 'El id proporcionado no existe',
                'name.require' => 'El nombre es requerido',
                'email.require' => 'El email es obligatorio',
                'email.email' => 'El email no tiene un formato valido',
            ]
        );
        try {

            $user = User::find($request['id']);
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->save();
            return response()->json(['succes' => 'Se actualizo el usuario']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Se presento un error inesperado ' . $th]);
        }
    }

    public function DeleteUser(Request $request)
    {
        $request = $request->validate(
            [
                'id' => 'require|exists:users,id',
            ],
            [
                'id.require' => 'El id es obligatorio',
                'id.exists' => 'El id proporcionado no existe',
            ]
        );
        try {
            $user = User::find($request['id'])->delete();
            return response()->json(['succes' => 'Se elimino el usuario']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Se presento un error inesperado ' . $th]);
        }
    }

    public function FindUser(Request $request)
    {
        $request = $request->validate(
            [
                'id' => 'require|exists:users,id',
            ],
            [
                'id.require' => 'El id es obligatorio',
                'id.exists' => 'El id proporcionado no existe',
            ]
        );
        try {
            $user = User::find($request['id']);
            return response()->json(['succes' => $user]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Se presento un error inesperado ' . $th]);
        }
    }
    public function AllUser(Request $request)
    {
        try {
            $user = User::all();
            return response()->json(['succes' => $user]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Se presento un error inesperado ' . $th]);
        }
    }
}
