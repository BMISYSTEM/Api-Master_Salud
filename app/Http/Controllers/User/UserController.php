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
                'fotoperfil'=>'nullable',
                'foto1'=>'nullable',
                'foto2'=>'nullable',
                'foto3'=>'nullable',
                'foto4'=>'nullable',
                'foto5'=>'nullable',
                'foto6'=>'nullable',
                'foto7'=>'nullable',
                'foto8'=>'nullable',
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

            $user = User::find($request['id']);
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->cargo = $request['cargo'] ? $request['cargo'] : '';
            $user->horarioatencion = $request['horarioatencion'] ? $request['horarioatencion'] : '';
            $user->publico = $request['publico'] ? $request['publico'] : '';
            $user->mediospago = $request['mediospago'] ? $request['mediospago'] : '';
            $user->fotoperfil = $request['fotoperfil'] ? $request['fotoperfil'] : '';
            $user->foto1 = $request['foto1'] ? $request['foto1'] : '';
            $user->foto2 = $request['foto2'] ? $request['foto2'] : '';
            $user->foto3 = $request['foto3'] ? $request['foto3'] : '';
            $user->foto4 = $request['foto4'] ? $request['foto4'] : '';
            $user->foto5 = $request['foto5'] ? $request['foto5'] : '';
            $user->foto6 = $request['foto6'] ? $request['foto6'] : '';
            $user->foto7 = $request['foto7'] ? $request['foto7'] : '';
            $user->foto8 = $request['foto8'] ? $request['foto8'] : '';
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

    public function updateInformacion()
    {

    }
}
