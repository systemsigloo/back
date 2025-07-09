<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'nombre', 'telefono', 'comentarios', 'total', 'estatus','metodo_pago',
         'total_usd',
                'total_bs',
                'tasa'  ,
               
                'pago'
    ];

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }
}