<?php

namespace App\Http\Controllers;

use App\Models\Materias;
use Illuminate\Http\Request;

class MateriasController extends Controller
{
    /**
     * Genera un array de objetos de Materia y lo regresa
     */
    public function list()
    {
        $materias = Materias::latest()->get();
        return $materias;
    }

    /**
     * Almacena un nuevo objeto de Materia en la base de datos
     */
    public function store(Request $request)
    {
        $camposValidados = $request->validate([
            'nombre' => 'required',
            'codigo' => 'required',
            'creditos' => 'required|numeric',
            'descripcion' => 'required',
        ]);

        $save = Materias::create($camposValidados);

        if ($save) {
            $response = [
                'success' => true,
                'message' => 'Materia agregada correctamente',
            ];
            return response()->json($response, 201);
        }

        $response = [
            'success' => false,
            'message' => 'Ha ocurrido un error, intentalo de nuevo',
        ];
        return response()->json($response, 200);
    }

    /**
     * Modifica y actualiza los datos de un objeto de Materia existente
     */
    public function update(Request $request)
    {
        $camposValidados = $request->validate([
            'nombre' => 'required',
            'codigo' => 'required',
            'creditos' => 'required',
            'descripcion' => 'required',
        ]);

        $materia = Materias::find($request->id);
        $save = $materia->update($camposValidados);

        if ($save) {
            $response = [
                'success' => true,
                'message' => 'Materia editada correctamente',
            ];
            return response()->json($response, 200);
        }

        $response = [
            'success' => false,
            'message' => 'Ha ocurrido un error, intentalo de nuevo',
        ];
        return response()->json($response, 200);
    }

    /**
     * Elimina de la base de datos un objeto de Materia existente
     */
    public function destroy(Request $request)
    {
        $materia = Materias::find($request->id);
        $delete = $materia->delete();

        if ($delete) {
            $response = [
                'success' => true,
                'message' => 'Materia eliminada exitosamente',
            ];
            return response()->json($response, 200);
        }

        $response = [
            'success' => false,
            'message' => 'Ha ocurrido un error, intentalo de nuevo',
        ];
        return response()->json($response, 200);
    }
}
