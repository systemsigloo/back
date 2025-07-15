<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\RateController;

Route::post('/login', [AuthApiController::class, 'login']);


Route::post('/pedidos', [PedidoController::class, 'store']);
Route::get('/pedidos', [PedidoController::class, 'index']);

Route::get('/rate', [RateController::class, 'getRateBCV']);

  Route::get('/test', function (Request $request) {
        return 'test';
     });

// Rutas protegidas con set.org
Route::middleware('set.org')->group(function () {
    Route::get('/test', function () {
        return 'test';
    });
    Route::get('/productos', [ProductoController::class, 'index']);
    Route::post('/productos', [ProductoController::class, 'store']);   // Agrega aquí más rutas protegidas
    Route::post('/categorias', [CategoriaController::class, 'store']);
    Route::get('/categorias', [CategoriaController::class, 'index']);

});
      

Route::middleware('auth')->group(function () {
    Route::get('/perfil', function (Request $request) {
        return response()->json([
            'usuario' => $request->user()
        ]);
    
    });





  Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy']);   
 Route::put('/categorias/{id}', [CategoriaController::class, 'update']);
 Route::put('/productos/{id}', [ProductoController::class, 'update']);
 Route::delete('/productos/{id}', [ProductoController::class, 'destroy']);


});
