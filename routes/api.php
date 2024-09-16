<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
    /**
     * user->create crea un usuario y ashea el password
     */
    Route::post('/user/create',[UserController::class,'createUser']);

})->middleware('auth:sanctum');

/**
 * Login 
 */
Route::post('/user/auth',[AuthController::class,'Auth']);