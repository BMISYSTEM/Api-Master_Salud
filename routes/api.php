<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\bold\BoldController;
use App\Http\Controllers\Caracteristicas\CaracteristicasController;
use App\Http\Controllers\CitasController\CitasController;
use App\Http\Controllers\Compras\ComprasController;
use App\Http\Controllers\Especialidades\EspecialidadesController;
use App\Http\Controllers\home\HomeController;
use App\Http\Controllers\Horarios\HorariosController;
use App\Http\Controllers\Marcas\MarcasController;
use App\Http\Controllers\Motivos\MotivosController;
use App\Http\Controllers\Productos\ProductosController;
use App\Http\Controllers\Promociones\PromocionesController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/users',function(){
        $user = Auth::user();
        return response()->json($user);
    });

    Route::post('/users/update',[UserController::class,'UpdateUser']);
    Route::post('/users/update/imagen',[UserController::class,'updateImagen']);
    /**Informacion del medico en el panel  */
    Route::get('/medic/all/private',[UserController::class,'findMedicPrivate']);
    /**
     * Marcas
     */
    Route::post('/marcas/create',[MarcasController::class,'createMarca']);
    Route::post('/marcas/update',[MarcasController::class,'updateMarca']);
    Route::post('/marcas/delete',[MarcasController::class,'deleteMarca']);
    Route::post('/marcas/find',[MarcasController::class,'findMarca']);
    /**
    * Caracteristicas
     */
    Route::post('/caracteristica/create',[CaracteristicasController::class,'createCaract']);
    Route::post('/caracteristica/delete',[CaracteristicasController::class,'deleteCarat']);
    Route::post('/caracteristica/update',[CaracteristicasController::class,'update']);

    /**
     * Promociones
     */
    Route::post('/promocion/create',[PromocionesController::class,'createPromocion']);
    Route::post('/promocion/update',[PromocionesController::class,'updatePromocion']);
    Route::post('/promocion/delete',[PromocionesController::class,'deletePromocion']);
    Route::post('/promocion/find',[PromocionesController::class,'findPromocion']);
    /**
     * Producto
     */
    Route::post('/producto/create',[ProductosController::class,'createProducto']);
    Route::post('/producto/update-image',[ProductosController::class,'updateImagen']);
    Route::post('/producto/update',[ProductosController::class,'updateProducto']);
    /**
     * Ventas
     */
    Route::get('/ventas/index',[ComprasController::class,'indexCompras']);
    Route::post('/ventas/index/productos',[ComprasController::class,'indexComprasProductos']);
    Route::post('/ventas/update/status',[ComprasController::class,'updateStatusEntrega']);
    // -------------------------------------Panel Medicos -------------------------------------------

    /**
     * Motivos
     */
    Route::post('/motivo/newmotivo',[MotivosController::class,'newMotivo']);
    Route::post('/motivo/delete',[MotivosController::class,'deleteMotivo']);
    Route::get('/motivo/all',[MotivosController::class,'allMotivo']);
    /**
     * horarios
     */
    Route::post('/horarios/newhorario',[HorariosController::class,'createHorario']);
    Route::post('/horarios/delete',[HorariosController::class,'deleteHorario']);
    Route::get('/horarios/all',[HorariosController::class,'horarioAll']);

    /**
     * comentarios
     */
    Route::post('/comentario/delete',[UserController::class,'deleteComentario']);
    Route::get('/comentario/all',[UserController::class,'allcomentarios']);
    /**
     * Citas
     */
    Route::get('/cita/delete',[CitasController::class,'deleteCita']);
    Route::get('/cita/atendido',[CitasController::class,'atendida']);
    /**
     * especialidades
     */
    Route::post('/especialidad/create',[EspecialidadesController::class,'createEspecialidad']);
    Route::post('/especialidad/update',[EspecialidadesController::class,'updateEspecialidad']);
    Route::post('/especialidad/delete',[EspecialidadesController::class,'deleteEspecialidad']);
    /**
     * home
     */
    Route::post('/home/create',[HomeController::class,'create']);
    Route::post('/home/banner',[HomeController::class,'banner']);
})->middleware('auth:sanctum');
/**
 * Compras
 */
Route::post('/compras/new',[ComprasController::class,'newCompra']);
/**
 * Login 
 */
Route::post('/user/auth',[AuthController::class,'Auth']);
/**
 * Listado de productos
 */
Route::get('/producto/index',[ProductosController::class,'allProdcuto']);
Route::post('/producto/index',[ProductosController::class,'allProdcuto']);
/**
 * Listado de promociones
 */
Route::get('/promocion/index',[PromocionesController::class,'allPromociones']);
/**
 * Listado de marcas
 */
Route::get('/marcas/index',[MarcasController::class,'allMarca']);
/**
 * user->create crea un usuario y ashea el password
 */
Route::post('/user/create',[UserController::class,'createUser']);
/**
 * Informacion del medico 
 *
 */
Route::get('/medic/all',[UserController::class,'allMedic']);
Route::post('/medic/find',[UserController::class,'findMedic']);
/**
 * caracteristicas
 */
Route::get('/caracteristica/all',[CaracteristicasController::class,'allcaract']);
/** comentarios del medico para el publico */
Route::post('/comentario/create',[UserController::class,'createComentario']);
Route::get('/comentario/all/medic',[UserController::class,'allcomentariosPublic']);
/** Agendar cita */
Route::post('/cita/create',[CitasController::class,'createCita']);
/**
 * especialidades
 */
Route::get('/especialidades/all',[EspecialidadesController::class,'all']);
/**
 * home
 */
Route::get('/home/all',[HomeController::class,'all']);
/**
 * controladores de despliegue
 */
Route::get('/config/all',function(){
    Artisan::call('migrate');
    Artisan::call('storage:link');
    return response()->json(['succes'=>'se ejecuto la migraciones y se creo el enlase simbolico']);
});

/* creacion de link para pago  */
Route::post("/linkpago",[BoldController::class,'createLinkPago']);
Route::post("/statuspago",[BoldController::class,'webHookBold']);