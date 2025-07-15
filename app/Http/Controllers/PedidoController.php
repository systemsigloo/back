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
         $orgId = config('app.org_id');
         $email = config('app.email');
        if (!$orgId) {
            abort(403, 'No se ha configurado una organización para este dominio.');
        }

        // Validar el request
        $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'comentarios' => 'nullable|string',           
            'total_usd' => 'nullable|numeric',
            'total_bs' => 'nullable|numeric',
            'rate' => 'nullable|numeric',
            'comprobante' => 'nullable|image|max:2048', // max 2MB,
            'metodoPago' => 'nullable|string',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|integer',
            'productos.*.nombre' => 'required|string',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric',
            'productos.*.subtotal' => 'required|numeric',
        ]);
         $rutaImagen = null;
        if ($request->hasFile('comprobante')) {
            $rutaImagen = $request->file('comprobante')->store('comprobantes', 'public');
        }
        DB::beginTransaction();

        try {
            // Crear el pedido
            $pedido = Pedido::create([
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'comentarios' => $request->comentarios,
                'total' => $request->total,
                'total_usd' => $request->total_usd,
                'total_bs' => $request->total_bs,
                'tasa' => $request->rate,
                'metodo_pago' => ($request->metodoPago == 'pagoMovil')?'p':'d',
                'pago' => $rutaImagen,
                'estatus' => 'pendiente',
                'org_id' => $orgId,
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
                    'org_id' => $orgId,
                ]);
            }

            DB::commit();
          //Mail::to('jesusgomezuribe@gmail.com')->send(new PedidoRecibido($request));
          // Enviar correo  delivery.goodfriends072025@gmail.com
       Mail::to($email)->send(new PedidoCreado($request));
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
