<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Producto extends Model
{     use SoftDeletes;
     protected $fillable = [
        'nombre',
        'precio',
        'descripcion',
        'categoria_id',
        'imagen','org_id',
    ];

    public function organization()
    {
        return $this->belongsTo(Org::class, 'org_id');
    }
}
