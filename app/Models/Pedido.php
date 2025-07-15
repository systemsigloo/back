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
               
                'pago','org_id',
    ];

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }

    // Relación muchos a uno con Org
    public function organization()
    {
        return $this->belongsTo(Org::class, 'org_id');
    }
}