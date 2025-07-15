<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $fillable = [
        'pedido_id', 'org_id','producto_id', 'nombre', 'cantidad', 'precio_unitario', 'subtotal'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    // Relación muchos a uno con Org
    public function organization()
    {
        return $this->belongsTo(Org::class, 'org_id');
    }
}
