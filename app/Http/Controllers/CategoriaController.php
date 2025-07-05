<?php
namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
         $categorias = Categoria::where('status','1')->orderBy('nombre')->get();

        return response()->json($categorias);
    }

     public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        $categoria = Categoria::create([
            'nombre' => $request->nombre,
            'status' => $request->status ?? 1,
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