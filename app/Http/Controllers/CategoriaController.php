<?php
namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {  $orgId = config('app.org_id');
        if (!$orgId) {
            abort(403, 'No se ha configurado una organización para este dominio.');
        }
         $categorias = Categoria::where('org_id',$orgId)->where('status','1')->orderBy('nombre')->get();

        return response()->json($categorias);
    }

     public function store(Request $request)
    {  $orgId = config('app.org_id');
        if (!$orgId) {
            abort(403, 'No se ha configurado una organización para este dominio.');
        }
        $request->validate([
            'nombre' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        $categoria = Categoria::create([
            'nombre' => $request->nombre,
            'status' => $request->status ?? 1,
            'org_id' => $orgId,
        ]);

        return response()->json([
            'message' => 'Categoría creada correctamente',
            'data' => $categoria
        ], 201);
    }


public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $request->validate([
            'nombre' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

         $categoria->fill($request->only([
            'nombre',
            'status' 
        ]));

         $categoria->save();

        return response()->json([
            'message' => 'Categoría creada correctamente',
            'data' => $categoria
        ], 201);
    }


public function destroy($id)
{
    $categoria = Categoria::findOrFail($id);
    $categoria->status = '0';
    
     $categoria->save();

    return response()->json([
        'message' => 'Producto eliminado correctamente (borrado suave)',
    ]);
}

}