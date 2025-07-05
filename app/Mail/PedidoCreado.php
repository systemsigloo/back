<?php

namespace App\Mail;

use App\Models\Producto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
class PedidoCreado extends Mailable
{
    use Queueable, SerializesModels;

    public $producto;

    public function __construct(Request $request)
    {
        $this->producto = $request;
    }

    public function build()
    {
        return $this->subject('Nuevo Producto Creado')
                    ->view('emails.pedido-creado')
                    ->with(['producto' => $this->producto]);
    }
}