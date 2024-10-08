<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Compras\ComprasController;
use App\Http\Controllers\Marcas\MarcasController;
use App\Http\Controllers\Productos\ProductosController;
use App\Http\Controllers\Promociones\PromocionesController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/users',function(){
        $user = Auth::user();
        return response()->json($user);
    });

    /**
     * user->create crea un usuario y ashea el password
     */
    Route::post('/user/create',[UserController::class,'createUser']);

    /**
     * Marcas
     */
    Route::post('/marcas/create',[MarcasController::class,'createMarca']);
    Route::post('/marcas/update',[MarcasController::class,'updateMarca']);
    Route::post('/marcas/delete',[MarcasController::class,'deleteMarca']);
    Route::post('/marcas/find',[MarcasController::class,'findMarca']);
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
    Route::post('producto/update-image',[ProductosController::class,'updateImagen']);
    Route::post('producto/update',[ProductosController::class,'updateProducto']);
    /**
     * Compras
     */
    Route::post('/compras/new',[ComprasController::class,'newCompra']);
})->middleware('auth:sanctum');

/**
 * Login 
 */
Route::post('/user/auth',[AuthController::class,'Auth']);

/**
 * Listado de productos
 */
Route::get('/producto/index',[ProductosController::class,'allProdcuto']);
/**
 * Listado de promociones
 */
 Route::get('/promocion/index',[PromocionesController::class,'allPromociones']);
/**
 * Listado de marcas
 */
Route::get('/marcas/index',[MarcasController::class,'allMarca']);

