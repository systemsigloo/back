<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Org extends Model
{
    // Habilitar soft deletes si deseas que las organizaciones se eliminen de forma lógica
    use SoftDeletes;

    // Especificar el nombre de la tabla si no sigue la convención de Laravel
    protected $table = 'org';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'name',
        'status',
    ];

    // Campos que se tratan como booleanos
    protected $casts = [
        'status' => 'boolean',
    ];

    // Relación uno a muchos con Users
    public function users()
    {
        return $this->hasMany(User::class, 'org_id');
    }

    // Relación uno a muchos con Categorias
    public function categorias()
    {
        return $this->hasMany(Categoria::class, 'org_id');
    }

    // Relación uno a muchos con Pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'org_id');
    }

    // Relación uno a muchos con DetallePedidos
    public function detallePedidos()
    {
        return $this->hasMany(DetallePedido::class, 'org_id');
    }

    // Relación uno a muchos con Productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'org_id');
    }


}