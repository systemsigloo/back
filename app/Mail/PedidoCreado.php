<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;

class PedidoCreado extends Mailable
{
    use Queueable, SerializesModels;

    public $pedidoData;

    public function __construct(Request $request)
    {
        $this->pedidoData = [
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'comentarios' => $request->comentarios,
            'metodo_pago' => $request->metodo_pago,
            'total_usd' => $request->total_usd,
            'total_bs' => $request->total_bs,
            'tasa' => $request->rate,
            'productos' => $request->productos,
            'comprobante' => $request->hasFile('comprobante') ? $request->file('comprobante')->getClientOriginalName() : null,
            'comprobante_path' => $request->hasFile('comprobante') ? storage_path('app/public/' . $request->file('comprobante')->store('comprobantes', 'public')) : null,
        ];
    }

    public function build()
    {
        $mail = $this->subject('Pedido: '.  $this->pedidoData['nombre'])
                     ->view('emails.pedido-creado')
                     ->with(['pedidoData' => $this->pedidoData]);

        if ($this->pedidoData['comprobante_path']) {
            $mail->attach($this->pedidoData['comprobante_path'], [
                'as' => $this->pedidoData['comprobante'],
                'mime' => 'image/*',
            ]);
        }

        return $mail;
    }
}
