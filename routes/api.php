<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [\App\Http\Controllers\Api\LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function (){

    Route::prefix('/unit')->group(function (){
        Route::get('/', [\App\Http\Controllers\Api\UnitController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\Api\UnitController::class, 'show']);
        Route::post('/', [\App\Http\Controllers\Api\UnitController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\Api\UnitController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\Api\UnitController::class, 'delete']);
    });

    Route::prefix('/category')->group(function (){
        Route::get('/', [\App\Http\Controllers\Api\CategoryController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\Api\CategoryController::class, 'show']);
        Route::post('/', [\App\Http\Controllers\Api\CategoryController::class, 'store']);
        Route::put('/{id}', [\App\Http\Controllers\Api\CategoryController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\Api\CategoryController::class, 'delete']);
    });
});
