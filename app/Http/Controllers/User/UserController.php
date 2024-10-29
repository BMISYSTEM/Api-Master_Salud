<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\registro;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $data = $request->validate(
            [
                'id' => 'required|exists:users,id',
                'name' => 'required',
                'apellido'=>'string',
                'email' => 'required|email',
                'cargo'=>'nullable',
                'horarioatencion'=>'nullable',
                'publico'=>'nullable',
                'mediospago'=>'nullable',
                'cedula'=>'nullable',
                'fijo'=>'nullable',
                'celular'=>'nullable',
                'direccion'=>'nullable',
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

            $user = User::findOrFail($data['id']);
            $user->update($data);
            return response()->json(['succes' => $user]);
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

    public function updateImagen(Request $request)
    {
        try {
            $Validate = $request->validate(
                [
                    'imagen'=>'required',
                    'file'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048'
                ],
                [
                    'imagen.require'=>'El numero de imagen es obligatorio',
                ]
            );
            $ruta = $request->file('file');
            $id = Auth::user()->id;
            $imagenPath = $ruta->store('fotos', 'public'); 
            $user = User::find($id);
            switch ($Validate['imagen'])
            {
                case 1:
                    $user->fotoperfil = $imagenPath;
                    break;
                case 2:
                    $user->foto1 = $imagenPath;
                    break;
                case 3:
                    $user->foto2 = $imagenPath;
                    break;
                case 4:
                    $user->foto3 = $imagenPath;
                    break;
                case 5:
                    $user->foto4 = $imagenPath;
                    break;  
                case 6:
                    $user->foto5 = $imagenPath;
                    break; 
                case 7:
                    $user->foto6 = $imagenPath;
                    break;   
                case 8:
                    $user->foto7 = $imagenPath;
                    break; 
                case 9:
                    $user->foto8 = $imagenPath;
                    break; 
            }
            $user->save();
            return response()->json(['succes'=>'La imagen se actualizo con exito']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'Se presento un error inesperado '.$th],500);
        }
    }


    public function allMedic()
    {
        $user = User::where('rol',2)->get();
        return response()->json(['succes' => $user]);
    }

    public function findMedic(Request $request)
    {
        $user = DB::select("select * from users where id = ".$request['id']);
        return response()->json(['succes' => $user]);
    }
}
