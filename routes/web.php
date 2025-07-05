<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PedidoController;


Route::get('/', function () {
    return "ttt";
});

Route::post('/pedidos', [PedidoController::class, 'store']);
Route::get('/categorias', [CategoriaController::class, 'index']);
Route::get('/productos', [ProductoController::class, 'index']);
Route::get('/pedidos', [PedidoController::class, 'index']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return 'sdf';
    });
});
require __DIR__.'/auth.php';
