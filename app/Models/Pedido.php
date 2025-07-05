<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'nombre', 'telefono', 'comentarios', 'total', 'estatus'
    ];

    public function detalles()
    {
        return $this->hasMany(DetallePedido::class);
    }
}