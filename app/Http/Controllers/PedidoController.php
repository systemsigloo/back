<?php
namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Mail\PedidoCreado;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PedidoController extends Controller
{
    public function store(Request $request)
    {
        // Validar el request
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'comentarios' => 'nullable|string',
            'total' => 'required|numeric',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|integer',
            'productos.*.nombre' => 'required|string',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric',
            'productos.*.subtotal' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            // Crear el pedido
            $pedido = Pedido::create([
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'comentarios' => $request->comentarios,
                'total' => $request->total,
                'estatus' => 'pendiente',
            ]);

            // Crear los detalles
            foreach ($request->productos as $prod) {
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $prod['producto_id'],
                    'nombre' => $prod['nombre'],
                    'cantidad' => $prod['cantidad'],
                    'precio_unitario' => $prod['precio_unitario'],
                    'subtotal' => $prod['subtotal'],
                ]);
            }

            DB::commit();
          //Mail::to('jesusgomezuribe@gmail.com')->send(new PedidoRecibido($request));
          // Enviar correo
        Mail::to('jesusgomezuribe@gmail.com')->send(new PedidoCreado($request));
            return response()->json([
                'message' => 'Pedido guardado correctamente',
                'pedido_id' => $pedido->id
            ], 200);
          
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Error al guardar el pedido '.$e->getMessage(),
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
