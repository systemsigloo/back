<?php
namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ProductoController extends Controller
{

    public function getNombre($_id){
        
        $categoria = Categoria::find($_id);
        return $categoria->nombre;
    }
    public function index()
    {   $orgId = config('app.org_id');
       
        if (!$orgId) {
            abort(403, 'No se ha configurado una organización para este dominio.');
        }
    
        return Producto::where('org_id',$orgId)->orderBy('orden','asc')->get()->map(function ($producto) {
            return [
                'id' => $producto->id,
                'nombre' => $producto->nombre,
                'categoria' => $this->getNombre($producto->categoria_id),
                'categoria_id' => $producto->categoria_id,
                'precio' => $producto->precio,
                'descripcion' => $producto->descripcion,
                'imagen' => $producto->imagen ? Storage::url($producto->imagen) : null, // Devuelve la URL completa
            ];
        });
    }

    public function store(Request $request)
    {
        $orgId = config('app.org_id');
        if (!$orgId) {
            abort(403, 'No se ha configurado una organización para este dominio.');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'nullable|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048', // max 2MB
        ]);

        $rutaImagen = null;
        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto = Producto::create([
            'categoria_id' => $request->categoria_id,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'imagen' => $rutaImagen,
            'org_id' => $orgId,
        ]);

        return response()->json([
            'message' => 'Producto creado exitosamente',
            'producto' => $producto,
        ], 201);
    }

    public function update(Request $request, $id)
{
    $producto = Producto::findOrFail($id);

    $request->validate([
        'nombre' => 'sometimes|required|string|max:255',
        'precio' => 'sometimes|required|numeric',
        'descripcion' => 'nullable|string',
        'categoria_id' => 'nullable|exists:categorias,id',
        'imagen' => 'nullable|image|max:2048', // imagen opcional
    ]);

    if ($request->hasFile('imagen')) {
        $rutaImagen = $request->file('imagen')->store('productos', 'public');
        $producto->imagen = $rutaImagen;
    }

    $producto->fill($request->only([
        'nombre',
        'precio',
        'descripcion',
        'categoria_id',
    ]));

    $producto->save();

    return response()->json([
        'message' => 'Producto actualizado correctamente',
        'producto' => $producto,
    ]);
}
public function destroy($id)
{
    $producto = Producto::findOrFail($id);
    $producto->delete();

    return response()->json([
        'message' => 'Producto eliminado correctamente (borrado suave)',
    ]);
}
}