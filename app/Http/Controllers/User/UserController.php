<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\registro;
use App\Models\comentario;
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
                'ciudad'=>'required',
                'virtual'=>'required',
                'presencial'=>'required'
                
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
                    'ciudad'=>$request['ciudad'],
                    'presencial'=>$request['presencial'],
                    'virtual'=>$request['virtual'],
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
    public function findMedicPrivate()
    {
        $id = Auth::user()->id;
        $rol = Auth::user()->rol;
        try {
            if($rol == 2)
            {
                
                $user = DB::select("select * from users where id = ".$id);
                $comentarios = DB::select('select * from comentarios where user = '.$id);
                $calificacion = DB::select('select COUNT(*) total, sum(calificacion) suma, (sum(calificacion)/count(*)) promedio from comentarios where user ='.$id);
                $motivos = DB::select("select * from motivos_consultas where user=".$id);
                $horarios = DB::select("select * from horarios where user=".$id);
                $citas = DB::select('select
                c.id,c.nombre,c.telefono,c.email,c.primera_visita,c.observacion,c.fecha_cita,c.atendido,
                m.nombre motivo,h.hora_inicio,h.hora_fin
                from citas c
                inner join motivos_consultas m on c.motivo = m.id
                inner join horarios h on c.horario = h.id
                where c.user = '.$id.'
                ');
                $resumenCitas = DB::select('select count(*) total,(select count(*) from citas where user = '.$id.' and atendido = 1 ) atendidos,
                (select count(*) from citas where user = '.$id.' and atendido = 0) pendientes
                from citas where user = '.$id);
            }else{
                $user = DB::select("select * from users where id = ".$id);
                $comentarios = DB::select('select * from comentarios ');
                $calificacion = DB::select('select COUNT(*) total, sum(calificacion) suma, (sum(calificacion)/count(*)) promedio from comentarios');
                $motivos = DB::select("select * from motivos_consultas");
                $horarios = DB::select("select * from horarios");
                $citas = DB::select('select
                c.id,c.nombre,c.telefono,c.email,c.primera_visita,c.observacion,c.fecha_cita,c.atendido,
                m.nombre motivo,h.hora_inicio,h.hora_fin
                from citas c
                inner join motivos_consultas m on c.motivo = m.id
                inner join horarios h on c.horario = h.id');
                $resumenCitas = DB::select('select count(*) total,(select count(*) from citas where user = 7 and atendido = 1 ) atendidos,
                (select count(*) from citas where  atendido = 0) pendientes
                from citas ');
            }
            //code...
        return response()->json(['succes' => $user,
        'motivos'=>$motivos,
        'horarios'=>$horarios,
        'calificacion'=>$calificacion,
        'comentarios'=>$comentarios,
        'citas'=>$citas,
        'resumen'=>$resumenCitas
        ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['error'=>$th]);
        }
    }
    public function findMedic(Request $request)
    {
        $user = DB::select("select * from users where id = ".$request['id']);
        $calificacion = DB::select('select COUNT(*) total, sum(calificacion) suma, (sum(calificacion)/count(*)) promedio from comentarios where user ='.$request['id']);
        $motivos = DB::select("select * from motivos_consultas where user=".$request['id']);
        $horarios = DB::select("select * from horarios where user=".$request['id']);
        return response()->json(['succes' => $user,'motivos'=>$motivos,'horarios'=>$horarios,'calificacion'=>$calificacion]);
    }

    public function createComentario(Request $request)
    {
        $data = $request->validate(
            [
                'nombre'=>'required',
                'email'=>'required|email',
                'observacion'=>'required',
                'calificacion'=>'required|numeric',
                'user'=>'required|exists:users,id'

            ]
        );
        try {
            $comentario = comentario::create(
                [
                    'nombre'=>$data['nombre'],
                    'email'=>$data['email'],
                    'observacion'=>$data['observacion'],
                    'calificacion'=>$data['calificacion'],
                    'user'=>$data['user'],
                ]
            );
            return response()->json(['succes'=>'se creo el omentario de forma correcta']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'error inesperado en el servidor: '.$th],500);
        }
    }

    public function deleteComentario(Request $request)
    {
        $data = $request->validate(
            [
                'id'=>'required|exists:comentarios,id'
            ]
        );
        try {
            $comentario = comentario::find($request['id'])->delete();
            return response()->json(['succes'=>'se elimino correctamente el comentario']);
        } catch (\Throwable $th) {
            return response()->json(['error'=>'error inesperado en el servidor: '.$th],500);
        }
    }

    public function allcomentariosPublic(Request $request)
    {
        $id = $request->query('id');
        $comentario = '';
        $comentario = comentario::where('user',$id)->get();
        return response()->json(['succes'=>$comentario]);
    }
}
