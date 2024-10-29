<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\registro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
                'email.unique' =>'El email ya existe ',
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
                    'rol'=>2
                ]
            );
            Mail::to($request['email'])->send(new registro($request));
            return response()->json(['succes' => 'Usuario creado de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Se genero un error inesperado ' . $th],500);
        }
    }

    public function UpdateUser(Request $request)
    {
        $request = $request->validate(
            [
                'id' => 'required|exists:users,id',
                'name' => 'required',
                'email' => 'required|email',
                'cargo'=>'nullable',
                'horarioatencion'=>'nullable',
                'publico'=>'nullable',
                'mediospago'=>'nullable',
            ],
            [
                'id.required' => 'El id es obligatorio',
                'id.exists' => 'El id proporcionado no existe',
                'name.required' => 'El nombre es requerido',
                'email.required' => 'El email es obligatorio',
                'email.email' => 'El email no tiene un formato valido',
            ]
        );
        try {

            $user = User::findOrFail($request['id']);
            $user->update($request);
            return response()->json(['succes' => 'Se actualizo el usuario']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Se presento un error inesperado ' . $th],500);
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

    public function updateInformacion()
    {

    }
}
