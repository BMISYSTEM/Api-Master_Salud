<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Marcas\MarcasController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){

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
    Route::get('/marcas/index',[MarcasController::class,'allMarca']);
    /**
     * ofertas
     */
})->middleware('auth:sanctum');

/**
 * Login 
 */
Route::post('/user/auth',[AuthController::class,'Auth']);